<?php

namespace Chess\Play;

use Chess\FenToBoard;
use Chess\Exception\PlayException;
use Chess\Movetext\RavMovetext;
use Chess\Movetext\SanMovetext;
use Chess\Play\SanPlay;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\PGN\AN\Color;

/**
 * Recursive Annotation Variation.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class RavPlay extends AbstractPlay
{
    /**
     * RAV movetext.
     *
     * @var array
     */
    protected RavMovetext $ravMovetext;

    /**
     * RAV breakdown.
     *
     * @var array
     */
    protected array $breakdown;

    /**
     * Resume the variations.
     *
     * @var array
     */
    protected array $resume;

    /**
     * Constructor.
     *
     * @param string $movetext
     * @param ClassicalBoard $board
     */
    public function __construct(string $movetext, ClassicalBoard $board = null)
    {
        $this->initialBoard = $board ?? new ClassicalBoard();
        $this->board = unserialize(serialize($board)) ?? new ClassicalBoard();
        $this->fen = [$this->board->toFen()];
        $this->ravMovetext = new RavMovetext($this->board->getMove(), $movetext);
        $this->ravMovetext->validate();

        $this->breakdown();
    }

    /**
     * Returns the RAV movetext.
     *
     * @return RavMovetext
     */
    public function getRavMovetext(): RavMovetext
    {
        return $this->ravMovetext;
    }

    /**
     * Returns the breakdown of the variations.
     *
     * @return array
     */
    public function getBreakdown(): array
    {
        return $this->breakdown;
    }

    /**
     * Semantically validated movetext.
     *
     * Makes the moves in the main variation of a RAV movetext.
     *
     * @throws \Chess\Exception\PlayException
     * @return \Chess\Play\RavPlay
     */
    public function validate(): RavPlay
    {
        $moves = (new SanMovetext(
            $this->ravMovetext->getMove(),
            $this->ravMovetext->main()
        ))->getMoves();

        foreach ($moves as $key => $val) {
            if (!$this->board->play($this->board->getTurn(), $val)) {
                throw new PlayException();
            }
        }

        $this->fen();

        return $this;
    }

    /**
     * Calculates the FEN history.
     *
     * @return \Chess\Play\RavPlay
     */
    protected function fen(): RavPlay
    {
        $sanPlay = (new SanPlay($this->breakdown[0], $this->initialBoard))->validate();
        $this->fen = $sanPlay->getFen();
        $this->resume[$this->breakdown[0]] = $sanPlay->getBoard();
        for ($i = 1; $i < count($this->breakdown); $i++) {
            $sanMovetext = new SanMovetext($this->ravMovetext->getMove(), $this->breakdown[$i]);
            foreach ($this->resume as $key => $val) {
                $sanMovetextKey = new SanMovetext($this->ravMovetext->getMove(), $key);
                if ($this->isParent($sanMovetextKey->getLastMove(), $sanMovetext->getFirstMove())) {
                    if ($this->isUndo($sanMovetextKey->getLastMove(), $sanMovetext->getFirstMove())) {
                        $undo = $val->undo();
                        $board = FenToBoard::create($undo->toFen(), $this->initialBoard);
                    } else {
                        $board = FenToBoard::create($val->toFen(), $this->initialBoard);
                    }
                }
            }
            $sanPlay = (new SanPlay($this->breakdown[$i], $board))->validate();
            $this->resume[$this->breakdown[$i]] = $sanPlay->getBoard();
            $fen = $sanPlay->getFen();
            array_shift($fen);
            $this->fen = [
                ...$this->fen,
                ...$fen,
            ];
        }

        return $this;
    }

    /**
     * A breakdown of the variations for further processing.
     */
    protected function breakdown(): void
    {
        $str = $this->ravMovetext->filtered();
        // escape parentheses enclosed in curly brackets
        preg_match_all('/{(.*?)}/', $str, $matches);
        foreach (array_filter($matches[0]) as $match) {
            $replaced = str_replace('(', '<--', $match);
            $replaced = str_replace(')', '-->', $replaced);
            $str = str_replace($match, $replaced, $str);
        }
        // split by parentheses outside the curly brackets
        $arr = preg_split("/[()]+/", $str, -1, PREG_SPLIT_NO_EMPTY);
        $arr = array_map('trim', $arr);
        $arr = array_values(array_filter($arr));
        // unescape parentheses enclosed in curly brackets
        foreach ($arr as &$item) {
            $item = str_replace('<--', '(', $item);
            $item = str_replace('-->', ')', $item);
        }

        $this->breakdown = $arr;
    }

    /**
     * Finds out if a node is a parent of another node.
     *
     * @param string $parent
     * @param string $child
     * @return bool
     */
    protected function isParent(string $parent, string $child): bool
    {
        $parent = new SanMovetext($this->ravMovetext->getMove(), $parent);
        $child = new SanMovetext($this->ravMovetext->getMove(), $child);
        if (!str_contains($this->ravMovetext->filtered($comments = false), "{$parent->getMovetext()})")) {
            if ($parent->getMetadata()->number->first === $child->getMetadata()->number->first) {
                return true;
            } elseif ($parent->getMetadata()->number->first !== $parent->getMetadata()->number->current) {
                if ($parent->getMetadata()->number->first + 1 === $child->getMetadata()->number->first) {
                    if ($child->getMetadata()->turn->start === Color::W) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Finds out if a move must be undone.
     *
     * @param string $parent
     * @param string $child
     * @return bool
     */
    protected function isUndo(string $parent, string $child)
    {
        $parent = new SanMovetext($this->ravMovetext->getMove(), $parent);
        $child = new SanMovetext($this->ravMovetext->getMove(), $child);
        if ($parent->getMetadata()->turn->current === $child->getMetadata()->turn->current) {
            return true;
        }

        return false;
    }
}

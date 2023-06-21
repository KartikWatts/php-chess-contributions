<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\AN\Termination;
use Chess\Variant\Classical\PGN\Move;

/**
 * Standard Algebraic Notation.
 *
 * @license GPL
 */
class SAN
{
    const SYMBOL_ELLIPSIS = '...';

    /**
     * Move.
     *
     * @var \Chess\Variant\Classical\PGN\Move
     */
    protected Move $move;

    /**
     * Movetext.
     *
     * @var string
     */
    protected string $movetext;

    /**
     * Array of PGN moves.
     *
     * @var array
     */
    protected array $moves;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        $this->move = $move;
        $this->movetext = $this->filter($movetext);
        $this->moves = [];
        $this->fill($this->movetext);
    }

    /**
     * Returns the array of PGN moves.
     *
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Validation.
     *
     * @return string
     */
    public function validate(): string
    {
        foreach ($this->moves as $move) {
            if ($move !== self::SYMBOL_ELLIPSIS) {
                $this->move->validate($move);
            }
        }

        return $this->toString();
    }

    /**
     * Converts the array of PGN moves to a string.
     *
     * @return string
     */
    public function toString(): string
    {
        $str = '';
        $offset = 0;
        if (isset($this->moves[0])) {
            if ($this->moves[0] === self::SYMBOL_ELLIPSIS) {
                $str = '1' . self::SYMBOL_ELLIPSIS . "{$this->moves[1]} ";
                $offset = 2;
            }
        }
        for ($i = $offset; $i < count($this->moves); $i++) {
            if ($i % 2 === 0) {
                $str .= (($i / 2) + 1) . ".{$this->moves[$i]}";
            } else {
                $str .= " {$this->moves[$i]} ";
            }
        }

        return trim($str);
    }

    /**
     * Returns an array representing the movetext as a sequence of moves.
     *
     * e.g. 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
     *
     * Array
     * (
     *     [0] => 1.d4 Nf6
     *     [1] => 1.d4 Nf6 2.Nf3 e6
     *     [2] => 1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+
     * )
     *
     * @return array
     */
    public function sequence(): array
    {
        $n = floor(count($this->moves) / 2);
        $sequence = [];
        for ($i = 0; $i < $n; $i++) {
            $j = 2 * $i;
            if (isset($this->moves[$j+1])) {
                $item = end($sequence) . ' ' .  $i + 1 .
                ".{$this->moves[$j]} {$this->moves[$j+1]}";
                $sequence[] = trim($item);
            }
        }

        return $sequence;
    }

    /**
     * Filters the given movetext for further processing.
     *
     * @param string $movetext
     */
    protected function filter(string $movetext): string
    {
        // remove PGN symbols
        $movetext = str_replace(Termination::values(), '', $movetext);
        // remove spaces between dots
        $movetext = preg_replace('/\s+\./', '.', $movetext);
        // remove comments
        $movetext = preg_replace("/\{[^)]+\}/", '', $movetext);
        // remove variations
        $movetext = preg_replace('/\(([^()]|(?R))*\)/', '', $movetext);
        // replace FIDE notation with PGN notation
        $movetext = str_replace('0-0', 'O-O', $movetext);
        $movetext = str_replace('0-0-0', 'O-O-O', $movetext);

        return $movetext;
    }

    /**
     * Fills the array of PGN moves.
     *
     * @param string $movetext
     */
    protected function fill(string $movetext): void
    {
        foreach (explode(' ', $movetext) as $key => $val) {
            if ($key === 0) {
                if (preg_match('/^[1-9][0-9]*\.\.\.(.*)$/', $val)) {
                    $exploded = explode(self::SYMBOL_ELLIPSIS, $val);
                    $this->moves[] = self::SYMBOL_ELLIPSIS;
                    $this->moves[] = $exploded[1];
                } elseif (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                    $this->moves[] = explode('.', $val)[1];
                } else {
                    $this->moves[] = $val;
                }
            } else {
                if (preg_match('/^[1-9][0-9]*\.(.*)$/', $val)) {
                    $this->moves[] = explode('.', $val)[1];
                } else {
                    $this->moves[] = $val;
                }
            }
        }

        $this->moves = array_values(array_filter($this->moves));
    }
}

<?php

namespace Chess\Variant\Chess960;

use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Chess960\StartPieces;
use Chess\Variant\Chess960\Rule\CastlingRule;

/**
 * Board
 *
 * Fischer Random chessboard representation.
 *
 * @author Jordi Bassagaña
 * @license GPL
 */
final class Board extends ClassicalBoard
{
    const VARIANT = '960';

    /**
     * Start position.
     *
     * @var array
     */
     private array $startPos;

    /**
     * Constructor.
     *
     * @param array $startPos
     */
    public function __construct(
        array $startPos = null,
        array $pieces = null,
        string $castlingAbility = '-'
    ) {
        $this->size = Square::SIZE;
        $this->sqs = Square::all();
        $this->startPos = $startPos ?? (new StartPosition())->getDefault();
        $this->castlingRule =  (new CastlingRule($this->startPos))->getRule();
        $this->move = new Move();
        if (!$pieces) {
            $pieces = (new StartPieces($this->startPos, $this->castlingRule))->create();
            $this->castlingAbility = CastlingAbility::START;
        } else {
            $this->castlingAbility = $castlingAbility;
        }
        foreach ($pieces as $piece) {
            $this->attach($piece);
        }

        $this->refresh();

        $this->startFen = $this->toFen();
    }

    /**
     * Returns the start position.
     *
     * @return array
     */
    public function getStartPos(): array
    {
        return $this->startPos;
    }
}

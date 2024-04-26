<?php

namespace Chess\Play;

use Chess\Variant\Classical\Board;

/**
 * AbstractPlay.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
abstract class AbstractPlay
{
    /**
     * Initial chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $initialBoard;

    /**
     * Resulting chess board.
     *
     * @var \Chess\Variant\Classical\Board
     */
    protected Board $board;

    /**
     * FEN history.
     *
     * @var array
     */
    protected array $fen;

    /**
     * Returns the chess board.
     *
     * @return \Chess\Variant\Classical\Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Returns the FEN history.
     *
     * @return array
     */
    public function getFen(): array
    {
        return $this->fen;
    }
}

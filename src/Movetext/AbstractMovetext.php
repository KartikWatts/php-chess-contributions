<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;

/**
 * AbstractMovetext.
 *
 * @license GPL
 */
abstract class AbstractMovetext
{
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
     * Validated movetext.
     *
     * @var string
     */
    protected string $validation;

    /**
     * Filtered movetext.
     *
     * @var string
     */
    protected string $filter;

    /**
     * First move.
     *
     * @var int
     */
    protected int $first;

    /**
     * Last move.
     *
     * @var int
     */
    protected int $last;

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\PGN\Move $move
     * @param string $movetext
     */
    public function __construct(Move $move, string $movetext)
    {
        $this->move = $move;
        $this->movetext = $movetext;
        $this->moves = [];
        $this->validation = $this->beforeInsert($movetext);
        $this->first();
        $this->last();
        $this->insert();
    }

    /**
     * Returns the move.
     *
     * @return \Chess\Variant\Classical\PGN\Move
     */
    public function getMove(): Move
    {
        return $this->move;
    }

    /**
     * Returns the movetext.
     *
     * @return string
     */
    public function getMovetext(): string
    {
        return $this->movetext;
    }

    /**
     * Returns the array of moves.
     *
     * @see \Chess\Play\RAV
     * @see \Chess\Play\SAN
     * @return array
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    /**
     * Returns the first move.
     *
     * @return int
     */
    public function getFirst(): int
    {
        return $this->first;
    }

    /**
     * Returns the last move.
     *
     * @return int
     */
    public function getLast(): int
    {
        return $this->last;
    }

    /**
     * Calculates the first move.
     */
    protected function first(): void
    {
        $exploded = explode(' ', $this->validation);
        $first = $exploded[0];
        $exploded = explode('.', $first);

        $this->first = intval($exploded[0]);
    }

    /**
     * Calculates the last move.
     */
    protected function last(): void
    {
        $exploded = explode(' ', $this->validation);
        $last = end($exploded);
        $exploded = explode('.', $last);

        $this->last = intval($exploded[0]);
    }

    /**
     * Before inserting elements into the array of moves.
     *
     * @return string
     */
    abstract protected function beforeInsert(): string;

    /**
     * Insert elements into the array of moves.
     */
    abstract protected function insert(): void;

    /**
     * Syntactically validated movetext.
     *
     * @throws \Chess\Exception\UnknownNotationException
     * @return string
     */
    abstract public function validate(): string;

    /**
     * Filtered movetext.
     *
     * @return string
     */
    abstract public function filter(): string;
}

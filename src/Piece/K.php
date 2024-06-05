<?php

namespace Chess\Piece;

use Chess\Exception\UnknownNotationException;
use Chess\Piece\AbstractPiece;
use Chess\Piece\RType;
use Chess\Variant\Classical\FEN\Field\CastlingAbility;
use Chess\Variant\Classical\PGN\AN\Castle;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * King.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class K extends AbstractPiece
{
    /**
     * Constructor.
     *
     * @param string $color
     * @param string $sq
     * @param array $size
     */
    public function __construct(string $color, string $sq, array $size)
    {
        parent::__construct($color, $sq, $size, Piece::K);

        $this->mobility = [];

        $this->mobility();
    }

    /**
     * Calculates the piece's mobility.
     *
     * @return \Chess\Piece\AbstractPiece
     */
    protected function mobility(): AbstractPiece
    {
        try {
            $file = $this->sq[0];
            $rank = $this->getSqRank() + 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = $this->sq[0];
            $rank = $this->getSqRank() - 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = $this->getSqRank();
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = $this->getSqRank();
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = $this->getSqRank() + 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = $this->getSqRank() + 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) - 1);
            $rank = $this->getSqRank() - 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        try {
            $file = chr(ord($this->sq[0]) + 1);
            $rank = $this->getSqRank() - 1;
            if ($this->isValidSq($file . $rank)) {
                $this->mobility[] = $file . $rank;
            }
        } catch (UnknownNotationException $e) {
        }

        return $this;
    }

    /**
     * Returns the piece's legal moves.
     *
     * @return array
     */
    public function sqs(): array
    {
        $sqs = [
            ...$this->sqsKing(),
            ...$this->sqsCaptures(),
            ...[$this->sqCastleLong()],
            ...[$this->sqCastleShort()]
        ];

        return array_filter(array_unique($sqs));
    }

    /**
     * Returns the squares defended by the piece.
     *
     * @return array|null
     */
    public function defendedSqs(): ?array
    {
        $sqs = [];
        foreach ($this->mobility as $sq) {
            if (in_array($sq, $this->board->getSqCount()->used->{$this->getColor()})) {
                $sqs[] = $sq;
            }
        }

        return $sqs;
    }

    public function sqCastleLong(): ?string
    {
        $rule = $this->board->getCastlingRule()[$this->getColor()][Piece::K][Castle::LONG];

        if (CastlingAbility::long($this->board->getCastlingAbility(), $this->getColor())) {
            if (
                ($this->board->getTurn() === $this->getColor() && !$this->board->isCheck()) &&
                !array_diff($rule['free'], $this->board->getSqCount()->free) &&
                empty(array_intersect($rule['attack'], $this->board->getSpaceEval()->{$this->oppColor()}))
            ) {
                return $rule['sq']['next'];
            }
        }

        return null;
    }

    public function sqCastleShort(): ?string
    {
        $rule = $this->board->getCastlingRule()[$this->getColor()][Piece::K][Castle::SHORT];

        if (CastlingAbility::short($this->board->getCastlingAbility(), $this->getColor())) {
            if (
                ($this->board->getTurn() === $this->getColor() && !$this->board->isCheck()) &&
                !array_diff($rule['free'], $this->board->getSqCount()->free) &&
                empty(array_intersect($rule['attack'], $this->board->getSpaceEval()->{$this->oppColor()}))
            ) {
                return $rule['sq']['next'];
            }
        }

        return null;
    }

    protected function sqsCaptures(): ?array
    {
        $sqsCaptures = [];
        foreach ($this->mobility as $sq) {
            if ($piece = $this->board->getPieceBySq($sq)) {
                if ($this->oppColor() === $piece->getColor()) {
                    if (empty($piece->defendingPieces())) {
                        $sqsCaptures[] = $sq;
                    }
                }
            }

        }

        return $sqsCaptures;
    }

    protected function sqsKing(): ?array
    {
        $sqsKing = array_intersect((array)$this->mobility, $this->board->getSqCount()->free);

        return array_diff($sqsKing, $this->board->getSpaceEval()->{$this->oppColor()});
    }

    /**
     * Returns the castle rook.
     *
     * @param string $type
     * @return R|null \Chess\Piece\R|null
     */
    public function getCastleRook(string $type): ?R
    {
        $rule = $this->board->getCastlingRule()[$this->getColor()][Piece::R][$type];
        if ($type === RType::CASTLE_LONG && $this->sqCastleLong()) {
            if ($piece = $this->board->getPieceBySq($rule['sq']['current'])) {
                if ($piece->getId() === Piece::R) {
                    return $piece;
                }
            }
        } elseif ($type === RType::CASTLE_SHORT && $this->sqCastleShort()) {
            if ($piece = $this->board->getPieceBySq($rule['sq']['current'])) {
                if ($piece->getId() === Piece::R) {
                    return $piece;
                }
            }
        }

        return null;
    }

    /**
     * Returns false.
     *
     * @return boolean
     */
    public function isPinned(): bool
    {
        return false;
    }
}

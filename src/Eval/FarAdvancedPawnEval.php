<?php

namespace Chess\Eval;

use Chess\Piece\P;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

/**
 * FarAdvancedPawnEval
 *
 * A pawn is far advanced if it is threatening to promote.
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class FarAdvancedPawnEval extends AbstractEval implements
    ElaborateEvalInterface,
    ExplainEvalInterface
{
    use ElaborateEvalTrait;
    use ExplainEvalTrait;

    const NAME = 'Far-advanced pawn';

    /**
     * Constructor.
     *
     * @param \Chess\Variant\Classical\Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        $this->range = [1, 4];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a small far advanced pawn advantage",
            "has some far advanced pawn advantage",
            "has a significant far advanced pawn advantage",
            "has a decisive far advanced pawn advantage",
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::P && $this->isFarAdvancedPawn($piece)) {
                $this->result[$piece->getColor()][] = $piece->getSq();
            }
        }

        $this->explain([
            Color::W => count($this->result[Color::W]),
            Color::B => count($this->result[Color::B]),
        ]);

        $this->elaborate($this->result);
    }

    /**
     * Finds out if a pawn is far advanced.
     *
     * @param \Chess\Piece\P $pawn
     * @return bool
     */
    private function isFarAdvancedPawn(P $pawn): bool
    {
        if ($pawn->getColor() === Color::W) {
            if ($pawn->getSqRank() >= 6) {
                return true;
            }
        } else {
            if ($pawn->getSqRank() <= 3) {
                return true;
            }
        }

        return false;
    }

    /**
     * Elaborate on the result.
     *
     * @param array $result
     */
    private function elaborate(array $result): void
    {
        $singular = $plural = 'threatening to promote';

        $this->shorten($result, $singular, $plural);
    }
}

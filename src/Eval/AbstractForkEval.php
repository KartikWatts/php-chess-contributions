<?php

namespace Chess\Eval;

use Chess\Piece\AbstractPiece;
use Chess\Variant\Classical\PGN\AN\Piece;

abstract class AbstractForkEval extends AbstractEval
{
    protected function sumValues(AbstractPiece $piece, array $attackedPieces)
    {
        $values = 0;
        $pieceValue = self::$value[$piece->getId()];
        foreach ($attackedPieces as $attackedPiece) {
            if ($attackedPiece->getId() !== Piece::K) {
                $attackedPieceValue = self::$value[$attackedPiece->getId()];
                if ($pieceValue < $attackedPieceValue) {
                    $values += $attackedPieceValue;
                }
            }
        }

        return $values;
    }
}

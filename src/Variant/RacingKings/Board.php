<?php

namespace Chess\Variant\RacingKings;

use Chess\Variant\AbstractBoard;
use Chess\Variant\RType;
use Chess\Variant\VariantType;
use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Square;
use Chess\Variant\Classical\Piece\B;
use Chess\Variant\Classical\Piece\K;
use Chess\Variant\Classical\Piece\N;
use Chess\Variant\Classical\Piece\Q;
use Chess\Variant\Classical\Piece\R;
use Chess\Variant\Classical\Rule\CastlingRule;

class Board extends AbstractBoard
{
    const VARIANT = 'racing-kings';

    public function __construct(array $pieces = null, string $castlingAbility = '-') {
        $this->color = new Color();
        $this->castlingRule = new CastlingRule();
        $this->square = new Square();
        $this->move = new Move();
        $this->castlingAbility = CastlingRule::NEITHER;
        $this->pieceVariant = VariantType::CLASSICAL;
        if (!$pieces) {
            $this->attach(new Q(Color::B, 'a1', $this->square));
            $this->attach(new R(Color::B, 'b1', $this->square, RType::CASTLE_SHORT));
            $this->attach(new B(Color::B, 'c1', $this->square));
            $this->attach(new N(Color::B, 'd1', $this->square));
            $this->attach(new N(Color::W, 'e1', $this->square));
            $this->attach(new B(Color::W, 'f1', $this->square));
            $this->attach(new R(Color::W, 'g1', $this->square, RType::CASTLE_SHORT));
            $this->attach(new Q(Color::W, 'h1', $this->square));
            $this->attach(new K(Color::B, 'a2', $this->square));
            $this->attach(new R(Color::B, 'b2', $this->square, RType::CASTLE_LONG));
            $this->attach(new B(Color::B, 'c2', $this->square));
            $this->attach(new N(Color::B, 'd2', $this->square));
            $this->attach(new N(Color::W, 'e2', $this->square));
            $this->attach(new B(Color::W, 'f2', $this->square));
            $this->attach(new R(Color::W, 'g2', $this->square, RType::CASTLE_LONG));
            $this->attach(new K(Color::W, 'h2', $this->square));
        } else {
            foreach ($pieces as $piece) {
                $this->attach($piece);
            }
            $this->castlingAbility = $castlingAbility;
        }

        $this->refresh();

        $this->startFen = $this->toFen();
    }

    public function play(string $color, string $pgn): bool
    {
        $clone = $this->clone();
        if ($clone->play($color, $pgn)) {
            if (!$clone->isCheck()) {
                return parent::play($color, $pgn);
            }
        }

        return false;
    }
}

<?php
namespace PGNChess\Piece;

use PGNChess\PGN;
use PGNChess\Piece\AbstractPiece;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Bishop;

/**
 * Class that represents a king.
 *
 * Rather than implementing everything from scratch, this class uses a rook and
 * a bishop in order to keep things simple.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license MIT
 */
class King extends AbstractPiece
{
    /**
     * @var PGNChess\Piece\Rook
     */
    private $rook;

    /**
     * @var PGNChess\Piece\Bishop
     */
    private $bishop;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $square
     */
    public function __construct($color, $square)
    {
        parent::__construct($color, $square, PGN::PIECE_KING);
        $this->rook = new Rook($color, $square, PGN::PIECE_ROOK);
        $this->bishop = new Bishop($color, $square, PGN::PIECE_BISHOP);
        $this->scope();
    }

    /**
     * Gets the castling rook associated to the king's next move.
     *
     * @param array $pieces
     *
     * @return null|PGNChess\Piece\Rook
     */
    public function getCastlingRook(array $pieces)
    {
        foreach ($pieces as $piece)
        {
            if (
                $piece->getIdentity() === PGN::PIECE_ROOK &&
                $piece->getPosition()->current === PGN::castling($this->getColor())->{PGN::PIECE_ROOK}->{$this->getMove()->pgn}->position->current
            )
            {
                return $piece;
            }
        }
        return null;
    }

    /**
     * Calculates the king's scope.
     */
    protected function scope()
    {
        $scope =  array_merge(
            (array) $this->rook->getPosition()->scope,
            (array) $this->bishop->getPosition()->scope
        );
        foreach($scope as $key => $val)
        {
            $scope[$key] = !empty($val[0]) ? $val[0] : null;
        }
        $this->position->scope = (object) array_filter(array_unique($scope));
    }

    public function getLegalMoves()
    {
        $moves = [];
        switch ($this->getMove()->type)
        {
            // TODO document how the king, which is an exception, works...
            case PGN::MOVE_TYPE_KING:
                $moves = array_values(
                    array_intersect(
                        array_values((array)$this->position->scope),
                        self::$squares->free
                    )

                );
                break;

            // TODO document how the king, which is an exception, works...
            case PGN::MOVE_TYPE_KING_CAPTURES:
                $moves = array_values(
                    array_intersect(
                        array_values((array)$this->position->scope),
                        array_merge(self::$squares->used->{$this->getOppositeColor()})
                    )
                );
                break;

            case PGN::MOVE_TYPE_KING_CASTLING_SHORT:
                $castlingShort = PGN::castling($this->getColor())->{PGN::PIECE_KING}->{PGN::CASTLING_SHORT};
                if (
                    in_array($castlingShort->freeSquares->f, self::$squares->free) &&
                    in_array($castlingShort->freeSquares->g, self::$squares->free)
                )
                {
                    $moves[] = $this->getMove()->position->next;
                }
                break;

            case PGN::MOVE_TYPE_KING_CASTLING_LONG:
                $castlingLong = PGN::castling($this->getColor())->{PGN::PIECE_KING}->{PGN::CASTLING_LONG};
                if (
                    in_array($castlingLong->freeSquares->b, self::$squares->free) &&
                    in_array($castlingLong->freeSquares->c, self::$squares->free) &&
                    in_array($castlingLong->freeSquares->d, self::$squares->free)
                )
                {
                    $moves[] = $this->getMove()->position->next;
                }
                break;
        }
        return $moves;
    }
}

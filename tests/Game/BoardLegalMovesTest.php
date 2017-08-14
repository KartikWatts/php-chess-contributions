<?php
namespace PGNChess\Tests\Board;

use PGNChess\Game\Board;
use PGNChess\PGN\Converter;
use PGNChess\PGN\Symbol;
use PGNChess\Piece\Bishop;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Queen;
use PGNChess\Piece\Rook;
use PGNChess\Piece\Type\RookType;

class LegalMovesTest extends \PHPUnit_Framework_TestCase
{
    public function testPlayRa6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new Queen(Symbol::WHITE, 'd1'),
            new King(Symbol::WHITE, 'e1'),
            new Bishop(Symbol::WHITE, 'f1'),
            new Knight(Symbol::WHITE, 'g1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::WHITE, 'b2'),
            new Pawn(Symbol::WHITE, 'c2'),
            new Pawn(Symbol::WHITE, 'd2'),
            new Pawn(Symbol::WHITE, 'e2'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new Rook(Symbol::BLACK, 'a8', RookType::CASTLING_LONG),
            new Knight(Symbol::BLACK, 'b8'),
            new Bishop(Symbol::BLACK, 'c8'),
            new Queen(Symbol::BLACK, 'd8'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'f8'),
            new Knight(Symbol::BLACK, 'g8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'a7'),
            new Pawn(Symbol::BLACK, 'b7'),
            new Pawn(Symbol::BLACK, 'c7'),
            new Pawn(Symbol::BLACK, 'd7'),
            new Pawn(Symbol::BLACK, 'e7'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ra6')));
    }

    public function testPlayRxa6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Rxa6')));
    }

    public function testPlayh6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'h6')));
    }

    public function testPlayhxg6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new Pawn(Symbol::WHITE, 'g6'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'hxg6')));
    }

    public function testPlayNc3()
    {
        $board = new Board;
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Nc3')));
    }

    public function testPlayNc6()
    {
        $board = new Board;
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nc6')));
    }

    public function testPlayNf6()
    {
        $board = new Board;
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nf6')));
    }

    public function testPlayNxc3InCustomBoard()
    {
        $pieces = [
            new Knight(Symbol::WHITE, 'b1'),
            new King(Symbol::WHITE, 'e1'),
            new Pawn(Symbol::WHITE, 'g6'),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'c3'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Nxc3')));
    }

    public function testPlayShortCastlingInCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new Knight(Symbol::WHITE, 'b1'),
            new Bishop(Symbol::WHITE, 'c1'),
            new Queen(Symbol::WHITE, 'd1'),
            new King(Symbol::WHITE, 'e1'),
            new Bishop(Symbol::WHITE, 'f1'),
            new Knight(Symbol::WHITE, 'g1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'b2'),
            new Pawn(Symbol::WHITE, 'c2'),
            new Pawn(Symbol::WHITE, 'd2'),
            new Pawn(Symbol::WHITE, 'e2'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new Rook(Symbol::BLACK, 'a8', RookType::CASTLING_LONG),
            new Knight(Symbol::BLACK, 'b8'),
            new Bishop(Symbol::BLACK, 'c8'),
            new Queen(Symbol::BLACK, 'd8'),
            new King(Symbol::BLACK, 'e8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'a7'),
            new Pawn(Symbol::BLACK, 'b7'),
            new Pawn(Symbol::BLACK, 'c7'),
            new Pawn(Symbol::BLACK, 'd7'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'O-O')));
    }

    public function testCheckIsFixedKe4()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke4')));
    }

    public function testCheckIsFixedKg3()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg3')));
    }

    public function testCheckIsFixedKg2()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg2')));
    }

    public function testCheckIsFixedKe2()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke2')));
    }

    public function testCheckIsFixedKe3()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'f3'), // in check!
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke3')));
    }

    public function testKingLegalMove()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'g3'),
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg2')));
    }

    public function testKingLegalCapture()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'g3'),
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'h2', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kxh2')));
    }

    public function testKingCanCaptureRookNotDefended()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'a3'),
            new Pawn(Symbol::WHITE, 'c3'),
            new Rook(Symbol::WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'g3'),
            new Pawn(Symbol::BLACK, 'a6'),
            new Pawn(Symbol::BLACK, 'b5'),
            new Pawn(Symbol::BLACK, 'c4'),
            new Knight(Symbol::BLACK, 'd3'),
            new Rook(Symbol::BLACK, 'f3', RookType::CASTLING_SHORT), // rook not defended
            new King(Symbol::BLACK, 'g5'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kxf3')));
    }

    public function testWhiteCastlesShortSicilianAfterNf6()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::BLACK, 'Nf6'));
        $this->assertEquals(true, $board->play(Converter::toObject(Symbol::WHITE, 'O-O')));
    }

    public function testWhiteCastlesShortSicilianAfterNf6BoardStatus()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::BLACK, 'Nf6'));
        $this->assertEquals(true, $board->play(Converter::toObject(Symbol::WHITE, 'O-O')));
    }

    public function testCastlingWithThreatsRemoved()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'd5'),
            new Pawn(Symbol::WHITE, 'e4'),
            new Pawn(Symbol::WHITE, 'f3'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'd6'),
            new Knight(Symbol::BLACK, 'g8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testCheckCastlingStatusAfterMovingRh1()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'a2'),
            new Pawn(Symbol::WHITE, 'd5'),
            new Pawn(Symbol::WHITE, 'e4'),
            new Pawn(Symbol::WHITE, 'f3'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new Rook(Symbol::WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::BLACK, 'e8'),
            new Bishop(Symbol::BLACK, 'f8'),
            new Knight(Symbol::BLACK, 'g8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->play(Converter::toObject('w', 'Rg1'));
        $board->play(Converter::toObject('b', 'Nf6'));
        $board->play(Converter::toObject('w', 'Rh1'));
        $board->play(Converter::toObject('b', 'Nd7'));
        $board->play(Converter::toObject('w', 'O-O')); // this won't be run
        $board->play(Converter::toObject('w', 'O-O-O')); // this will be run
        $whiteSquaresUsed = [
            'a2',
            'd5',
            'e4',
            'f3',
            'g2',
            'h2',
            'h1',
            'c1',
            'd1'
        ];
        $whiteSpace = [
            'd2', // rook
            'd3',
            'd4',
            'e1',
            'f1',
            'g1',
            'b3', // pawns
            'c6',
            'e6',
            'f5',
            'g4',
            'g3',
            'h3',
            'b1', // king
            'b2',
            'c2',
            'd2',
            'e1', // rook
            'f1',
            'g1'
        ];
        $whiteSpace = array_filter(array_unique($whiteSpace));
        sort($whiteSpace);
        $whiteAttack = [];
        $this->assertEquals($whiteSquaresUsed, $board->getSquares()->used->w);
        $this->assertEquals($whiteSpace, $board->getControl()->space->w);
        $this->assertEquals($whiteAttack, $board->getControl()->attack->w);
    }

    public function testEnPassantf3()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'e2'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'e4'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7'),
            new King(Symbol::BLACK, 'e8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'f4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'exf3')));
    }

    public function testEnPassantf6()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'e5'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'e7'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h7'),
            new King(Symbol::BLACK, 'e8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'f5')));
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'exf6')));
    }

    public function testEnPassanth3()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'e2'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'e7'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g4'),
            new Pawn(Symbol::BLACK, 'h7'),
            new King(Symbol::BLACK, 'e8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'h4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'gxh3')));
    }

    public function testEnPassantg3()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'e2'),
            new Pawn(Symbol::WHITE, 'f2'),
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h2'),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'e7'),
            new Pawn(Symbol::BLACK, 'f7'),
            new Pawn(Symbol::BLACK, 'g7'),
            new Pawn(Symbol::BLACK, 'h4'),
            new King(Symbol::BLACK, 'e8'),
            new Rook(Symbol::BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'g4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'hxg3')));
    }

    public function testPawnPromotion()
    {
        $pieces = [
            new Pawn(Symbol::WHITE, 'g2'),
            new Pawn(Symbol::WHITE, 'h7'),
            new King(Symbol::WHITE, 'e1'),
            new Rook(Symbol::WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::BLACK, 'c7'),
            new Pawn(Symbol::BLACK, 'd7'),
            new Pawn(Symbol::BLACK, 'e7'),
            new Bishop(Symbol::BLACK, 'd6'),
            new King(Symbol::BLACK, 'e8')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'h8=Q')));
    }
}

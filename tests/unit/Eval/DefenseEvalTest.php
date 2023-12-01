<?php

namespace Chess\Tests\Unit\Board;

use Chess\Eval\DefenseEval;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;

class DefenseEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function D06()
    {
        $D06 = file_get_contents(self::DATA_FOLDER.'/sample/D06.pgn');

        $board = (new SanPlay($D06))->validate()->getBoard();

        $expected = [
            'w' => [
                'a2', 'b1', 'b2', 'c1', 'd1', 'd4', 'e1', 'e2', 'e2', 'e2',
                'e2', 'f1', 'f2', 'g1', 'g2', 'h2',
            ],
            'b' => [
                'a7', 'b7', 'b8', 'c8', 'd5', 'd8', 'e7', 'e7', 'e7', 'e7',
                'e8', 'f7', 'f8', 'g7', 'g8', 'h7',
            ],
        ];

        $result = (new DefenseEval($board))->getResult();

        $this->assertSame($expected, $result);
    }
}

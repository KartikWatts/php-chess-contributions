<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Eval\KingSafetyEval;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class KingSafetyEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $kSafetyEval = (new KingSafetyEval(new Board()))->eval();

        $expected = [
            'w' => 0,
            'b' => 0,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }

    /**
     * @test
     */
    public function A00()
    {
        $A00 = file_get_contents(self::DATA_FOLDER.'/sample/A00.pgn');

        $board = (new SanPlay($A00))->validate()->getBoard();

        $kSafetyEval = (new KingSafetyEval($board))->eval();

        $expected = [
            'w' => -1,
            'b' => 0,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }

    /**
     * @test
     */
    public function B25()
    {
        $B25 = file_get_contents(self::DATA_FOLDER.'/sample/B25.pgn');

        $board = (new SanPlay($B25))->validate()->getBoard();

        $kSafetyEval = (new KingSafetyEval($board))->eval();

        $expected = [
            'w' => 0,
            'b' => 0,
        ];

        $this->assertSame($expected, $kSafetyEval);
    }
}

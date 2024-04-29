<?php

namespace Chess\Computer;

use Chess\Variant\Classical\Board;

/**
 * RandomComputer
 *
 * @author Jordi Bassagaña
 * @license MIT
 */
class RandomComputer extends AbstractComputer
{
    /**
     * Returns a chess move.
     *
     * @param \Chess\Variant\Classical\Board $board
     * @return null|object
     */
    public function move(Board $board): ?object
    {
        $clone = unserialize(serialize($board));

        $legal = [];
        foreach ($clone->getPieces($clone->getTurn()) as $piece) {
            if ($sqs = $piece->sqs()) {
                $legal[$piece->getSq()] = $sqs;
            }
        }

        $from = array_rand($legal);
        shuffle($legal[$from]);
        $to = $legal[$from][0];

        $lan = "{$from}{$to}";

        if ($clone->playLan($clone->getTurn(), $lan)) {
            $last = array_slice($clone->getHistory(), -1)[0];
            return (object) [
                'pgn' => $last->move->pgn,
                'lan' => $lan,
            ];
        }

        return null;
    }
}

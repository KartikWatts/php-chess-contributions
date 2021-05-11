<?php

namespace Chess\ML\Supervised\Regression;

use Chess\Heuristic\Picture\AbstractHeuristicPicture;
use Chess\PGN\Symbol;

/**
 * Addition labeller.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class AdditionLabeller implements LabellerInterface
{
    private $heuristicPicture;

    private $sample;

    private $label;

    public function __construct(AbstractHeuristicPicture $heuristicPicture, array $sample = [])
    {
        $this->heuristicPicture = $heuristicPicture;

        $this->sample = $sample;

        $this->label = [
            Symbol::WHITE => 0,
            Symbol::BLACK => 0,
        ];
    }

    public function label(): array
    {
        foreach ($this->sample as $color => $arr) {
            foreach ($arr as $key => $val) {
                $this->label[$color] += $val;
            }
        }

        return $this->label;
    }
}

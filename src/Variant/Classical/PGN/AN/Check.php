<?php

namespace Chess\Variant\Classical\PGN\AN;

use Chess\Variant\Classical\PGN\AbstractNotation;

class Check extends AbstractNotation
{
    const REGEX = '[\+\#]{0,1}';
}

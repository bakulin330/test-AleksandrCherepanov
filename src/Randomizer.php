<?php declare(strict_types=1);

namespace Mottor;

class Randomizer
{
    public function getRandomInt(int $min, int $max)
    {
        return random_int($min, $max);
    }
}
<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractGenerator;
use PetrKnap\RainbowTables\Plugin\Crc32\Crc32Generator;

class Crc32GeneratorTest extends AbstractGeneratorTest
{
    /**
     * @return AbstractGenerator
     */
    protected function createGenerator()
    {
        return new Crc32Generator();
    }
}
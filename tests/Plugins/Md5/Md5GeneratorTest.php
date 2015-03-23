<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractGenerator;
use PetrKnap\RainbowTables\Plugin\Md5\Md5Generator;

class Md5GeneratorTest extends AbstractGeneratorTest
{
    /**
     * @return AbstractGenerator
     */
    protected function createGenerator()
    {
        return new Md5Generator();
    }
}
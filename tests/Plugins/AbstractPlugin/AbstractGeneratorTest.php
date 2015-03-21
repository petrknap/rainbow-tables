<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractGenerator;

abstract class AbstractGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return AbstractGenerator
     */
    abstract protected function createGenerator();

    public function testGenerateBlockWorks()
    {
        $generator = $this->createGenerator();

        $singleBlock = $generator->generateBlock();

        $this->assertCount($generator::MAX_BLOCK_SIZE, $singleBlock);

        for($i = 0; $i < 5; $i++) {
            $currentBlock = $generator->generateBlock($i);
            $this->assertCount($generator::BLOCK_SIZE, $currentBlock);
        }
    }
}
<?php

use PetrKnap\RainbowTables\Hash\Md5\HashMd5Generator;

class HashMd5GeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HashMd5Generator
     */
    private $range;

    public function setUp()
    {
        $this->range = new HashMd5Generator();
    }

    public function testGenerateBlockWorks()
    {
        $singleBlock = $this->range->generateBlock();

        $this->assertCount(HashMd5Generator::MAX_BLOCK_SIZE, $singleBlock);

        for($i = 0; $i < 5; $i++) {
            $currentBlock = $this->range->generateBlock($i);
            $this->assertCount(HashMd5Generator::BLOCK_SIZE, $currentBlock);
        }
    }
}
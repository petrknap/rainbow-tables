<?php

use PetrKnap\RainbowTables\Core\Main;
use PetrKnap\RainbowTables\Core\Exception;
use PetrKnap\RainbowTables\Hash\Md5\HashMd5Generator;
use PetrKnap\RainbowTables\Hash\Md5\HashMd5Storage;
use PetrKnap\Utils\DataStorage\Database;

class MainTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HashMd5Storage
     */
    private $storage;

    /**
     * @var HashMd5Generator
     */
    private $generator;

    public function setUp()
    {
        $database = new Database();
        $database->Type = Database::TYPE_SQLite;
        $database->HostOrPath = ":memory:";

        $this->storage = new HashMd5Storage($database, __CLASS__);

        $this->generator = new HashMd5Generator();
    }

    public function testCanGenerateRainbowTable()
    {
        Main::generateRainbowTable($this->storage, $this->generator, 1, 5);
    }

    public function testCanFindRecordInRainbowTable()
    {
        $this->testCanGenerateRainbowTable();

        $block3 = $this->generator->generateRange(3);

        foreach($block3 as $record) {
            try {
                $this->assertSame($record->getKey(), Main::findRecordInRainbowTable($this->storage, $record)->getKey());
            }
            catch(Exception $e) {
                $this->fail($e->getMessage());
            }
        }

        $block3 = $this->generator->generateRange(7);

        foreach($block3 as $record) {
            try {
                $this->assertSame($record->getKey(), Main::findRecordInRainbowTable($this->storage, $record)->getKey());
                $this->fail("Unknown record found.");
            }
            catch(Exception $e) {
                $this->assertTrue(true);
            }
        }
    }
}
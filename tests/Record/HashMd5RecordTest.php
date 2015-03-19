<?php

use PetrKnap\RainbowTables\Record\HashMd5Record;
use PetrKnap\Utils\Security\Hash;

class HashMd5RecordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HashMd5Record
     */
    private $record;

    public function setUp() {
        $this->record = new HashMd5Record();
        $this->record->setData(array("input" => __CLASS__));
    }

    public function testGetKeyWorks()
    {
        $expectedKey = Hash::B64MD5(__CLASS__);

        $this->assertEquals($expectedKey, $this->record->getKey());
    }

    public function testGetDataWorks()
    {
        $expectedData = array(
            "input" => __CLASS__,
            "output" => Hash::B64MD5(__CLASS__)
        );

        $this->assertEquals($expectedData, $this->record->getData());
    }

    public function testSetDataWorks()
    {
        $expectedData = array(
            "input" => __METHOD__,
            "output" => Hash::B64MD5(__METHOD__)
        );

        $this->record->setData(array("input" => __METHOD__));

        $this->assertEquals($expectedData, $this->record->getData());
    }
}
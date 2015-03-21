<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;

abstract class AbstractRecordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @return AbstractRecord
     */
    abstract protected function createRecord($data);

    abstract protected function calculateKey($inputData);

    abstract protected function calculateOutputData($inputData);

    /**
     * @var AbstractRecord
     */
    private $record;

    public function setUp() {
        $this->record = $this->createRecord(array("input_data" => __CLASS__));
    }

    public function testGetKeyWorks()
    {
        $expectedKey = $this->calculateKey(__CLASS__);

        $this->assertEquals($expectedKey, $this->record->getKey());
    }

    public function testGetDataWorks()
    {
        $expectedData = array(
            "input_data" => __CLASS__,
            "output_data" => $this->calculateOutputData(__CLASS__)
        );

        $this->assertEquals($expectedData, $this->record->getData());
    }

    public function testSetDataWorks()
    {
        $expectedData = array(
            "input_data" => __METHOD__,
            "output_data" => __CLASS__
        );

        $this->record->setData($expectedData);

        $this->assertEquals($expectedData, $this->record->getData());
    }
}
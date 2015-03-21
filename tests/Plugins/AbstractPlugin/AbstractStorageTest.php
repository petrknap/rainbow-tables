<?php

use PetrKnap\RainbowTables\Core\StorageException;
use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractStorage;
use PetrKnap\Utils\DataStorage\Database;

abstract class AbstractStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param Database $database
     * @param string $name
     * @return AbstractStorage
     */
    abstract protected function createStorage($database, $name);

    /**
     * @param array $data
     * @return AbstractRecord
     */
    abstract protected function createRecord($data);

    /**
     * @param string $string
     * @return array
     */
    protected function createDataFromString($string) {
        return array("input_data" => $string);
    }

    /**
     * @var Database
     */
    private $database;

    /**
     * @var AbstractStorage
     */
    private $storage;

    /**
     * @var AbstractRecord
     */
    private $record;

    public function setUp()
    {
        $this->database = new Database();
        $this->database->Type = Database::TYPE_SQLite;
        $this->database->HostOrPath = ":memory:";
        $this->database->connect();

        $this->storage = $this->createStorage($this->database, __CLASS__);

        $this->record = $this->createRecord($this->createDataFromString(__CLASS__));
    }

    public function testCreateStorageWorks()
    {
        try {
            $this->storage->createStorage();

            $countOfRecords = $this->database->FetchArray(
                $this->database->Query(
                    sprintf("SELECT COUNT(*) AS cnt FROM %s", __CLASS__)
                ),
                Database::FETCH_ASSOC
            )["cnt"];

            $this->assertEquals(0, $countOfRecords);
        }
        catch(StorageException $se) {
            $this->fail($se->getMessage());
        }
    }

    public function testSaveRecordWorks()
    {
        $this->testCreateStorageWorks();

        try {
            $this->storage->saveRecord($this->record);

            $countOfRecords = $this->database->FetchArray(
                $this->database->Query(
                    sprintf("SELECT COUNT(*) AS cnt FROM %s", __CLASS__)
                ),
                Database::FETCH_ASSOC
            )["cnt"];

            $this->assertEquals(1, $countOfRecords);
        }
        catch(StorageException $se) {
            $this->fail($se->getMessage());
        }

        try {
            $this->storage->saveRecord($this->record);
            $this->fail("Unique constraint fails.");
        }
        catch(StorageException $ignored) {
            $this->assertTrue(true);
        }
    }

    public function testFindRecordWorks()
    {
        $this->testSaveRecordWorks();

        try {
            $foundRecord = $this->storage->findRecord($this->record);

            $this->assertEquals($this->record->getData(), $foundRecord->getData());
        }
        catch(StorageException $se) {
            $this->fail($se->getMessage());
        }

        try {
            $this->record->setData($this->createDataFromString(__METHOD__));

            $this->storage->findRecord($this->record);
            $this->fail("Unknown record found.");
        }
        catch(StorageException $ignored) {
            $this->assertTrue(true);
        }
    }

    public function testRemoveRecordWorks()
    {
        $this->testSaveRecordWorks();

        try {
            $this->storage->removeRecord($this->record);

            $countOfRecords = $this->database->FetchArray(
                $this->database->Query(
                    sprintf("SELECT COUNT(*) AS cnt FROM %s", __CLASS__)
                ),
                Database::FETCH_ASSOC
            )["cnt"];

            $this->assertEquals(0, $countOfRecords);
        }
        catch(StorageException $se) {
            $this->fail($se->getMessage());
        }
    }
}
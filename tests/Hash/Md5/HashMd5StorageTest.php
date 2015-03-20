<?php

use PetrKnap\RainbowTables\Core\StorageException;
use PetrKnap\RainbowTables\Hash\Md5\HashMd5Record;
use PetrKnap\RainbowTables\Hash\Md5\HashMd5Storage;
use PetrKnap\Utils\DataStorage\Database;

class HashMd5StorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @var HashMd5Storage
     */
    private $storage;

    /**
     * @var HashMd5Record
     */
    private $record;

    public function setUp()
    {
        $this->database = new Database();
        $this->database->Type = Database::TYPE_SQLite;
        $this->database->HostOrPath = ":memory:";
        $this->database->connect();

        $this->storage = new HashMd5Storage($this->database, __CLASS__);

        $this->record = new HashMd5Record();
        $this->record->setData(array("input" => __CLASS__));
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
            $this->record->setData(array("input" => __METHOD__));

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
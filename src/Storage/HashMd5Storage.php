<?php

namespace PetrKnap\RainbowTables\Storage;

use PetrKnap\RainbowTables\Record\FindableInterface;
use PetrKnap\RainbowTables\Record\HashMd5Record;
use PetrKnap\RainbowTables\Record\RecordInterface;
use PetrKnap\Utils\DataStorage\Database;
use PetrKnap\Utils\Security\Hash;

class HashMd5Storage implements StorageInterface
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @var string
     */
    private $name;

    public function __construct(Database $database, $name = __CLASS__)
    {
        $this->database = $database;
        $this->name = $name;
    }

    public function createStorage()
    {
        $this->database->IWillBeCareful();
        $this->database->CreateQuery(
            sprintf(
                "CREATE TABLE IF NOT EXISTS %s (
                  id VARCHAR(%u),
                  md5_input TEXT UNIQUE,
                  md5_output VARCHAR(%u)
                )",
                $this->name,
                Hash::B64MD5length,
                Hash::B64MD5length
            ),
            Database::TYPE_MySQL
        );
    }

    public function saveRecord(RecordInterface $record)
    {
        try {
            $this->database->Query(
                sprintf(
                    "INSERT INTO %s (id, md5_input, md5_output) VALUES (:output, :input, :output)",
                    $this->name
                ),
                $record->getData()
            );
        }
        catch(\Exception $e) {
            throw new StorageException($e);
        }
    }

    /**
     * @param FindableInterface $record
     * @return RecordInterface
     * @throws StorageException
     */
    public function findRecord(FindableInterface $record)
    {
        try {
            $resultSet = $this->database->Query(
                sprintf(
                    "SELECT * FROM %s WHERE id = ?",
                    $this->name
                ),
                $record->getKey()
            );
            $result = $this->database->FetchArray($resultSet, Database::FETCH_ASSOC);

            if(!$result) {
                throw new \Exception(
                    sprintf(
                        "Record %s not found.",
                        $record->getKey()
                    )
                );
            }

            $foundRecord = new HashMd5Record();
            $foundRecord->setData(array(
                "input" => $result["md5_input"],
                "output" => $result["md5_output"]
            ));

            return $foundRecord;
        }
        catch(\Exception $e) {
            throw new StorageException($e);
        }
    }

    public function removeRecord(FindableInterface $record)
    {
        $this->database->IWillBeCareful();
        $this->database->Query(
            sprintf(
                "DELETE FROM %s WHERE id = ?",
                $this->name
            ),
            $record->getKey()
        );
    }
}
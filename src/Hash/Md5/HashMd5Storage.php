<?php

namespace PetrKnap\RainbowTables\Hash\Md5;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;
use PetrKnap\RainbowTables\Core\StorageException;
use PetrKnap\RainbowTables\Core\StorageInterface;
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

    public function __construct(Database $database, $name = "rainbow_table")
    {
        $this->database = $database;
        $this->name = $name;

        if(!$this->database->IsConnected) {
            $this->database->Connect();
        }
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

    public function saveRecords(array $records) {
        try {
            $this->database->BeginTransaction();
            foreach ($records as $record) {
                $this->saveRecord($record);
            }
            $this->database->Commit();
            return null;
        }
        catch(StorageException $se) {
            $this->database->RollBack();
            return $se;
        }
    }

    public function saveRecord($record)
    {
        try {
            if(!($record instanceof RecordInterface) || !($record instanceof FindableInterface)) {
                throw new \Exception(
                    sprintf(
                        "The %s must implements %s and %s.",
                        get_class($record),
                        RecordInterface::class,
                        FindableInterface::class
                    )
                );
            }

            $this->database->Query(
                sprintf(
                    "INSERT INTO %s (id, md5_input, md5_output) VALUES (:id, :input, :output)",
                    $this->name
                ),
                array_merge(
                    array(
                        "id" => $record->getKey()
                    ),
                    $record->getData()
                )
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
<?php

namespace PetrKnap\RainbowTables\Plugin\AbstractPlugin;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;
use PetrKnap\RainbowTables\Core\StorageException;
use PetrKnap\RainbowTables\Core\StorageInterface;
use PetrKnap\Utils\DataStorage\Database;

abstract class AbstractStorage implements StorageInterface
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @var string
     */
    private $name;

    public function __construct(Database $database, $name)
    {
        $this->database = $database;
        $this->name = sprintf("rainbow_tables__%s", $name);

        if(!$this->database->IsConnected) {
            $this->database->Connect();
        }
    }

    abstract protected function getTypeDefinitionsForKey();

    abstract protected function getTypeDefinitionsForInputData();

    abstract protected function getTypeDefinitionsForOutputData();

    public function createStorage()
    {
        // Create main table
        $this->database->IWillBeCareful();
        $this->database->CreateQuery(
            sprintf(
                "CREATE TABLE IF NOT EXISTS %s__data (
                  id %s,
                  input_data %s,
                  output_data %s
                )",
                $this->name,
                $this->getTypeDefinitionsForKey(),
                $this->getTypeDefinitionsForInputData(),
                $this->getTypeDefinitionsForOutputData()
            ),
            Database::TYPE_SQLite
        );

        // Create index for key
        $this->database->IWillBeCareful();
        $this->database->CreateQuery(
            sprintf(
                "CREATE INDEX IF NOT EXISTS %s__idx__id ON %s__data (id)",
                $this->name,
                $this->name
            ),
            Database::TYPE_SQLite
        );

        // Create index for input
        $this->database->IWillBeCareful();
        $this->database->CreateQuery(
            sprintf(
                "CREATE UNIQUE INDEX IF NOT EXISTS %s__idx__input_data ON %s__data (input_data)",
                $this->name,
                $this->name
            ),
            Database::TYPE_SQLite
        );

        // Create index for output
        $this->database->IWillBeCareful();
        $this->database->CreateQuery(
            sprintf(
                "CREATE INDEX IF NOT EXISTS %s__idx__output_data ON %s__data (output_data)",
                $this->name,
                $this->name
            ),
            Database::TYPE_SQLite
        );

        // Create view with collisions
        $this->database->CreateQuery(
            sprintf(
                "CREATE VIEW IF NOT EXISTS %s__collisions AS
                    SELECT input_data, output_data
                    FROM %s__data
                    WHERE output_data IN (
                        SELECT output_data
                        FROM %s__data
                        GROUP BY output_data
                        HAVING COUNT(*) > 1
                    )
                    ORDER BY output_data, input_data
                ",
                $this->name,
                $this->name,
                $this->name
            ),
            Database::TYPE_SQLite
        );
    }

    abstract protected function createRecord($data);

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
                    "INSERT INTO %s__data (id, input_data, output_data) VALUES (:id, :input_data, :output_data)",
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
                    "SELECT * FROM %s__data WHERE id = ?",
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

            return $this->createRecord($result);
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
                "DELETE FROM %s__data WHERE id = ?",
                $this->name
            ),
            $record->getKey()
        );
    }
}
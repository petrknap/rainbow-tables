<?php

namespace PetrKnap\RainbowTables\Plugin\AbstractPlugin;

use PetrKnap\RainbowTables\Core\Main;
use PetrKnap\Utils\DataStorage\Database;

abstract class AbstractScripts
{
    const BATCH_SIZE = 100;

    private $storage;

    private $generator;

    private function __construct()
    {
        // Private constructor
    }

    abstract protected function createStorage(Database $database);

    abstract protected function createGenerator();

    abstract public function stopMe($i);

    public function getStorage()
    {
        if(!$this->storage) {
            $database = new Database();
            $database->Type = Database::TYPE_SQLite;
            $database->HostOrPath = __DIR__ . "/../../../database.sqlite";

            $this->storage = $this->createStorage($database);
        }
        return $this->storage;
    }

    public function getGenerator()
    {
        if(!$this->generator) {
            $this->generator = $this->createGenerator();
        }
        return $this->generator;
    }

    public static function generate()
    {
        /** @var self $_this */
        $self = get_called_class();
        $_this = new $self();

        Main::$VERBOSE = true;
        Main::generateRainbowTable($_this->getStorage(), $_this->getGenerator());
    }
}

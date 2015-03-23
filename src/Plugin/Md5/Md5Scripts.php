<?php

namespace PetrKnap\RainbowTables\Plugin\Md5;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractScripts;
use PetrKnap\Utils\DataStorage\Database;

class Md5Scripts extends AbstractScripts
{
    /**
     * @var Md5Storage
     */
    private $storage;

    /**
     * @var Md5Generator
     */
    private $generator;

    protected function createStorage(Database $database)
    {
        $this->storage = new Md5Storage($database, "md5");

        return $this->storage;
    }

    protected function createGenerator()
    {
        if(!$this->generator) {
            $this->generator = new Md5Generator();
        }

        return $this->generator;
    }

    public function stopMe($i)
    {
        return $this->createGenerator()->wasEndOfFileReached();
    }
}

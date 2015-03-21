<?php

namespace PetrKnap\RainbowTables\Plugin\Crc32;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractScripts;
use PetrKnap\Utils\DataStorage\Database;

class Crc32Scripts extends AbstractScripts
{
    protected function createStorage(Database $database)
    {
        return new Crc32Storage($database, "crc32");
    }

    protected function createGenerator()
    {
        return new Crc32Generator();
    }

    public function stopMe($i)
    {
        return ($i > 999999999);
    }
}
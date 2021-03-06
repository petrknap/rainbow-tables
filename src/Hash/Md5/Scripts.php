<?php

namespace PetrKnap\RainbowTables\Hash\Md5;

use PetrKnap\RainbowTables\Core\Main;
use PetrKnap\Utils\DataStorage\Database;

class Scripts
{
    private static function getStorage() {
        $database = new Database();
        $database->Type = Database::TYPE_SQLite;
        $database->HostOrPath = "HashMd5.sqlite";

        return new HashMd5Storage($database);
    }

    public static function generate()
    {
        Main::$VERBOSE = true;

        $i = 0;
        while(true) {
            Main::generateRainbowTable(self::getStorage(), new HashMd5Generator(), $i, $i + HashMd5Generator::BLOCK_SIZE);
            $i += HashMd5Generator::BLOCK_SIZE + 1;
        }
    }
}

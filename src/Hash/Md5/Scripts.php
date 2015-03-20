<?php

namespace PetrKnap\RainbowTables\Hash\Md5;

use PetrKnap\RainbowTables\Core\Main;
use PetrKnap\Utils\DataStorage\Database;

class Scripts
{
    const BATCH_SIZE = 100;

    private static function getStorage() {
        $database = new Database();
        $database->Type = Database::TYPE_SQLite;
        $database->HostOrPath = __DIR__ . "/database.sqlite";

        return new HashMd5Storage($database);
    }

    public static function generate()
    {
        Main::$VERBOSE = true;

        $i = 0;
        while(true) {
            Main::generateRainbowTable(self::getStorage(), new HashMd5Generator(), $i, $i + self::BATCH_SIZE);
            $i += self::BATCH_SIZE + 1;
        }
    }
}

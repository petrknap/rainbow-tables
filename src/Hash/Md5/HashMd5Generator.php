<?php

namespace PetrKnap\RainbowTables\Hash\Md5;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\GeneratorInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;

class HashMd5Generator implements GeneratorInterface
{
    const BLOCK_SIZE = 9999;
    const MAX_BLOCK_SIZE = 999999;

    /**
     * @param int $blockNumber
     * @return RecordInterface[]|FindableInterface[]
     */
    public function generateBlock($blockNumber = -1)
    {
        if($blockNumber < 0) {
            $stop = self::MAX_BLOCK_SIZE;
        }
        else {
            $stop = self::BLOCK_SIZE;
        }

        $data = array();
        for($index = 1; $index <= $stop; $index++) {
            $record = new HashMd5Record();
            $record->setData(array("input" => "{$blockNumber}:{$index}"));
            $data[] = $record;
        }

        return $data;
    }
}

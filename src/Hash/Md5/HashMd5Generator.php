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
    public function generateRange($blockNumber = -1)
    {
        if($blockNumber < 0) {
            $from = 0;
            $to = self::MAX_BLOCK_SIZE;
        }
        else {
            $from = $blockNumber * self::BLOCK_SIZE;
            $to = ($blockNumber + 1) * self::BLOCK_SIZE;
        }

        $data = array();
        for($index = $from; $index < $to; $index++) {
            $record = new HashMd5Record();
            $record->setData(array("input" => $index));
            $data[] = $record;
        }

        return $data;
    }
}

<?php

namespace PetrKnap\RainbowTables\Plugin\Crc32;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractGenerator;

class Crc32Generator extends AbstractGenerator
{
    protected function createRecord($data)
    {
        $record = new Crc32Record();

        $record->setData($data);

        return $record;
    }

    protected function createData($blockNumber, $index)
    {
        return array("input_data" => "{$blockNumber}:{$index}");
    }
}

<?php

namespace PetrKnap\RainbowTables\Plugin\Crc32;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractStorage;

class Crc32Storage extends AbstractStorage
{
    protected function getTypeDefinitionsForKey()
    {
        return "INTEGER";
    }

    protected function getTypeDefinitionsForInputData()
    {
        return "TEXT";
    }

    protected function getTypeDefinitionsForOutputData()
    {
        return "INTEGER";
    }

    protected function createRecord($data)
    {
        $record = new Crc32Record();

        $record->setData($data);

        return $record;
    }
}
<?php

namespace PetrKnap\RainbowTables\Plugin\Crc32;

use PetrKnap\RainbowTables\Core\DictionaryToGeneratorAdapter;

class Crc32Generator extends DictionaryToGeneratorAdapter
{

    protected function getPathToDictionaryFile()
    {
        return __DIR__ . "/../../../dictionary.txt";
    }

    protected function createRecord($inputData)
    {
        $record = new Crc32Record();

        $record->setData(array("input_data" => $inputData));

        return $record;
    }
}
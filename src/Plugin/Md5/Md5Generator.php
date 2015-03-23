<?php

namespace PetrKnap\RainbowTables\Plugin\Md5;

use PetrKnap\RainbowTables\Core\DictionaryToGeneratorAdapter;

class Md5Generator extends DictionaryToGeneratorAdapter
{

    protected function getPathToDictionaryFile()
    {
        return __DIR__ . "/../../../dictionary.txt";
    }

    protected function createRecord($inputData)
    {
        $record = new Md5Record();

        $record->setData(array("input_data" => $inputData));

        return $record;
    }
}

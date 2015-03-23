<?php

namespace PetrKnap\RainbowTables\Plugin\Md5;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;
use PetrKnap\RainbowTables\Core\StorageException;
use PetrKnap\RainbowTables\Core\StorageInterface;
use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractStorage;
use PetrKnap\Utils\DataStorage\Database;
use PetrKnap\Utils\Security\Hash;

class Md5Storage extends AbstractStorage
{
    protected function getTypeDefinitionsForKey()
    {
        return sprintf("VARCHAR(%u)", Hash::B64MD5length);
    }

    protected function getTypeDefinitionsForInputData()
    {
        return "TEXT";
    }

    protected function getTypeDefinitionsForOutputData()
    {
        return sprintf("VARCHAR(%u)", Hash::B64MD5length);
    }

    protected function createRecord($data)
    {
        $record = new Md5Record();

        $record->setData($data);

        return $record;
    }
}

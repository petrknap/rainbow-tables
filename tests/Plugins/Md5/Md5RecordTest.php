<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\RainbowTables\Plugin\Md5\Md5Record;
use PetrKnap\Utils\Security\Hash;

class Md5RecordTest extends AbstractRecordTest
{
    /**
     * @param array $data
     * @return AbstractRecord
     */
    protected function createRecord($data)
    {
        $record = new Md5Record();

        $record->setData($data);

        return $record;
    }

    protected function calculateKey($inputData)
    {
        return Hash::B64MD5($inputData);
    }

    protected function calculateOutputData($inputData)
    {
        return Hash::B64MD5($inputData);
    }
}
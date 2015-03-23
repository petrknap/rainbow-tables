<?php

namespace PetrKnap\RainbowTables\Plugin\Md5;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\Utils\Security\Hash;

class Md5Record extends AbstractRecord
{
    protected function generateOutputData($input)
    {
        return Hash::B64MD5($input);
    }
}

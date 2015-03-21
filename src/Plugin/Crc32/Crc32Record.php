<?php

namespace PetrKnap\RainbowTables\Plugin\Crc32;

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;

class Crc32Record extends AbstractRecord
{
    /**
     * @param string $input
     * @return int
     */
    protected function generateOutputData($input)
    {
        return crc32($input);
    }
}
<?php

namespace PetrKnap\RainbowTables\Core;

interface GeneratorInterface
{
    /**
     * Returns block of records
     *
     * @param int $blockNumber
     * @return RecordInterface[]
     */
    public function generateBlock($blockNumber = -1);
}

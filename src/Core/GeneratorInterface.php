<?php

namespace PetrKnap\RainbowTables\Core;

interface GeneratorInterface
{
    /**
     * Returns block of records
     *
     * @param int|null $blockNumber
     * @return RecordInterface[]
     */
    public function generateBlock($blockNumber = null);
}

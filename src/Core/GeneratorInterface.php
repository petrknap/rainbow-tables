<?php

namespace PetrKnap\RainbowTables\Core;

interface GeneratorInterface
{
    /**
     * Returns range of input data
     *
     * @param int $index
     * @return RecordInterface[]
     */
    public function generateRange($index = -1);
}

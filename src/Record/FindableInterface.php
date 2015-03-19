<?php

namespace PetrKnap\RainbowTables\Record;

interface FindableInterface
{
    /**
     * Returns key which represents record
     *
     * @return string
     */
    public function getKey();
}

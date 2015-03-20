<?php

namespace PetrKnap\RainbowTables\Core;

interface FindableInterface
{
    /**
     * Returns key which represents record
     *
     * @return string
     */
    public function getKey();
}

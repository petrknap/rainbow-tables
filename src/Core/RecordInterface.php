<?php

namespace PetrKnap\RainbowTables\Core;

interface RecordInterface
{
    /**
     * Returns record serialized into array
     *
     * @return array
     */
    public function getData();

    /**
     * Hydrate object by array of serialized data
     *
     * @param array $data
     */
    public function setData(array $data);

    /**
     * Returns string representation of this object
     *
     * @return string
     */
    public function __toString();
}

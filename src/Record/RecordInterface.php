<?php

namespace PetrKnap\RainbowTables\Record;

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
}

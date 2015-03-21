<?php

namespace PetrKnap\RainbowTables\Plugin\AbstractPlugin;

use PetrKnap\RainbowTables\Core\GeneratorInterface;

abstract class AbstractGenerator implements GeneratorInterface
{
    const BLOCK_SIZE = 9999;
    const MAX_BLOCK_SIZE = 999999;

    /**
     * @param int $blockNumber
     * @return AbstractRecord[]
     */
    public function generateBlock($blockNumber = -1)
    {
        if($blockNumber < 0) {
            $stop = self::MAX_BLOCK_SIZE;
        }
        else {
            $stop = self::BLOCK_SIZE;
        }

        $records = array();
        for($index = 1; $index <= $stop; $index++) {
            $records[] = $this->createRecord($this->createData($blockNumber, $index));
        }

        return $records;
    }

    abstract protected function createRecord($data);

    abstract protected function createData($blockNumber, $index);
}

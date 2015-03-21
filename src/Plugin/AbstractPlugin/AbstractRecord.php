<?php

namespace PetrKnap\RainbowTables\Plugin\AbstractPlugin;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;

abstract class AbstractRecord implements RecordInterface, FindableInterface
{
    private $inputData;

    private $outputData;

    public function getKey()
    {
        return $this->outputData;
    }

    public function getData()
    {
        return array(
            "input_data" => $this->inputData,
            "output_data" => $this->outputData
        );
    }

    public function setData(array $data)
    {
        $this->inputData = $data["input_data"];

        if(isset($data["output_data"])) {
            $this->outputData = $data["output_data"];
        }
        else {
            $this->outputData = $this->generateOutputData($data["input_data"]);
        }
    }

    public function __toString()
    {
        return sprintf("%s", $this->getKey());
    }

    abstract protected function generateOutputData($input);
}
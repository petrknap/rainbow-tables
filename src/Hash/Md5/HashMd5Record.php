<?php

namespace PetrKnap\RainbowTables\Hash\Md5;

use PetrKnap\RainbowTables\Core\FindableInterface;
use PetrKnap\RainbowTables\Core\RecordInterface;
use PetrKnap\Utils\Security\Hash;

class HashMd5Record implements RecordInterface, FindableInterface
{
    private $input;

    private $output;

    public function getKey()
    {
        return $this->output;
    }

    public function getData()
    {
        return array(
            "input" => $this->input,
            "output" => $this->output
        );
    }

    public function setData(array $data)
    {
        $this->input = $data["input"];

        if(isset($data["output"])) {
            $this->output = $data["output"];
        }
        else {
            $this->output = Hash::B64MD5($data["input"]);
        }
    }

    public function __toString()
    {
        return sprintf("%s = %s", $this->output, $this->input);
    }
}
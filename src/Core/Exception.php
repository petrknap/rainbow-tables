<?php

namespace PetrKnap\RainbowTables\Core;


class Exception extends \Exception
{
    public function __construct(\Exception $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }
}

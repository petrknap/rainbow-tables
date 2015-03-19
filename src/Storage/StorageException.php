<?php

namespace PetrKnap\RainbowTables\Storage;


class StorageException extends \Exception
{
    public function __construct(\Exception $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }
}

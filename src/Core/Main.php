<?php

namespace PetrKnap\RainbowTables\Core;

class Main
{
    /**
     * @var bool
     */
    public static $VERBOSE = false;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var GeneratorInterface
     */
    private $generator;

    public static function generateRainbowTable(StorageInterface $storage, GeneratorInterface $generator, $firstBlockNumber, $lastBlockNumber) {
        $_this = new self($storage, $generator);
        for($blockNumber = $firstBlockNumber; $blockNumber <= $lastBlockNumber; $blockNumber++) {
            $_this->processBlock($blockNumber);
        }
    }

    public static function findRecordInRainbowTable(StorageInterface $storage, FindableInterface $record)
    {
        $_this = new self($storage);
        return $_this->findRecord($record);
    }

    private function __construct(StorageInterface $storage, GeneratorInterface $generator = null) {
        $this->storage = $storage;
        $this->generator = $generator;

        $this->storage->createStorage();
    }

    public function processBlock($blockNumber) {
        $records = $this->generator->generateRange($blockNumber);
        $exception = $this->storage->saveRecords($records);
        if(self::$VERBOSE) {
            $last = array_pop($records);
            $first = $records[0];
            if(!$exception) {
                fwrite(STDOUT, "  INFO: Block from {$first} to {$last} saved.\n");
            }
            else {
                fwrite(STDOUT, "  ERROR: Block from {$first} to {$last} failed.\nWARNING: {$exception->getMessage()}\n");
            }
        }
    }

    public function findRecord(FindableInterface $record) {
        return $this->storage->findRecord($record);
    }
}

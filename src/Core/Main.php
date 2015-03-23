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

    public static function generateRainbowTable(StorageInterface $storage, GeneratorInterface $generator) {
        $_this = new self($storage, $generator);
        $blockNumber = 0;

        while(true) {
            try {
                $_this->processBlock($blockNumber++);
            }
            catch(\Exception $e) {
                if(self::$VERBOSE) {
                    fwrite(STDOUT, "  ERROR: {$e->getMessage()}\n");
                }
                break;
            }
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
        $records = $this->generator->generateBlock($blockNumber);
        $exception = $this->storage->saveRecords($records);
        if (self::$VERBOSE) {
            $last = array_pop($records);
            if (!empty($records)) {
                $first = $records[0];
            } else {
                $first = $last;
            }
            if (!$exception) {
                fwrite(STDOUT, "  INFO: Block from {$first} to {$last} saved.\n");
            } else {
                fwrite(STDOUT, "  ERROR: Block from {$first} to {$last} failed.\nWARNING: {$exception->getMessage()}\n");
            }
        }
    }

    public function findRecord(FindableInterface $record) {
        return $this->storage->findRecord($record);
    }
}

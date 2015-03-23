<?php

namespace PetrKnap\RainbowTables\Core;

abstract class DictionaryToGeneratorAdapter implements GeneratorInterface
{
    const BLOCK_SIZE = 999;

    protected $dictionaryHandle = null;

    protected $lastBlockNumber = -2;

    protected $lastBlock = array();

    protected $endOfFileReached = false;

    abstract protected function getPathToDictionaryFile();

    abstract protected function createRecord($inputData);

    public function __construct()
    {
        $this->openDictionary();
    }

    public function __destruct()
    {
        $this->closeDictionary();
    }

    protected function openDictionary()
    {
        $this->dictionaryHandle = fopen($this->getPathToDictionaryFile(), "r");
        $this->lastBlockNumber = -1;
        $this->lastBlock = array();
        $this->endOfFileReached = false;
    }

    protected function closeDictionary()
    {
        if($this->dictionaryHandle) {
            fclose($this->dictionaryHandle);
        }
        $this->dictionaryHandle = null;
        $this->endOfFileReached = true;
    }

    public function wasEndOfFileReached()
    {
        return $this->endOfFileReached;
    }

    public function generateBlock($blockNumber = null)
    {
        try {
            // Reopen file
            if ($this->lastBlockNumber === null || $blockNumber < $this->lastBlockNumber) {
                $this->closeDictionary();
                $this->openDictionary();
            }

            if ($this->dictionaryHandle === null) {
                throw new \Exception("Dictionary handle is null.");
            }

            // Return the same result
            else {
                if ($blockNumber == $this->lastBlockNumber) {
                    // Return last result
                    return $this->lastBlock;
                }
            }

            // Skip records before block
            for ($i = $this->lastBlockNumber > 0 ? $this->lastBlockNumber : 0; $i < $blockNumber; $i++) {
                for ($j = 0; $j < self::BLOCK_SIZE; $j++) {
                    if (($ignored = fgets($this->dictionaryHandle)) === false) {
                        throw new \Exception("End of file reached before block {$blockNumber}.");
                    }
                }
            }

            // Load records from block
            $j = 0;
            $this->lastBlock = array();
            while (($line = fgets($this->dictionaryHandle)) !== false) {
                $line = trim($line);
                $this->lastBlock[] = $this->createRecord($line);
                $j++;
                if ($blockNumber !== null && $j >= self::BLOCK_SIZE) {
                    break;
                }
            }

            $this->lastBlockNumber = $blockNumber;

            return $this->lastBlock;
        }
        catch (\Exception $e) {
            throw new DictionaryToGeneratorAdapterException($e);
        }
    }
}
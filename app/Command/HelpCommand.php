<?php

namespace Tyorkin\HyperParserApplication\Command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class HelpCommand implements CommandInterface
{
   
    const NAME = 'help';

    /**
     * @param array $params
     */
    public function execute(array $params = [])
    {
        echo "Available commands:\n";
        $path = __DIR__;
        $commandClassList = [];

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $commandClassList[] = $namespace . '\\' . $tokens[$index][1];
                }
            }
        }

        foreach ($commandClassList as $commandClass) {
            if (class_exists($commandClass) && is_callable(array($commandClass, 'getDescription'))) {
                /** @var CommandInterface $command */
                $command = new $commandClass();
                echo($command->getDescription());
                echo "\n";
            }
        }
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "{$this->getName()} - Return list of available commands.";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

}
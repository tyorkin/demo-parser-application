<?php

namespace Tyorkin\HyperParserApplication\Command;

class CommandRegister
{
    private $commands = [];

    public function registerCommand(CommandInterface $command)
    {
        $this->commands[] = $command;
    }

    public function runCommand(string $commandName, array $params = [])
    {
        if ($commandName == 'help') {
            $this->help();
            exit;
        }
        $command = $this->findCommand($commandName);
        if ($command) {
            $command->execute($params);

            return true;
        }

        return false;
    }

    private function help()
    {
        echo "Available commands:\n";
        foreach ($this->commands as $command) {
            $description = $command->getDescription();
            echo $description . "\n\n";
        }
    }

    private function findCommand(string $commandName): ?CommandInterface
    {
        /** @var CommandInterface $command */
        foreach ($this->commands as $command) {
            if ($command->getName() == $commandName) {
                return $command;
            }
        }

        return null;
    }
}
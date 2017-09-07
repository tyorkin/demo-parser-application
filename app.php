<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tyorkin\HyperParserApplication\Command\CommandRegister;
use Tyorkin\HyperParserApplication\Command\HelpCommand;
use Tyorkin\HyperParserApplication\Command\ParseCommand;
use Tyorkin\HyperParserApplication\Command\ReportCommand;

$commandRegister = new CommandRegister();
$helpCommand = new HelpCommand();
$parseCommand = new ParseCommand();
$reportCommand = new ReportCommand();
$commandRegister->registerCommand($parseCommand);
$commandRegister->registerCommand($reportCommand);
$commandRegister->registerCommand($helpCommand);
$params = $argv;
array_shift($params);
$command = array_shift($params);
if (!$command) {
    exit;
}

$result = $commandRegister->runCommand($command, $params);
if (!$result) {
    echo "Command not found.\n";
}



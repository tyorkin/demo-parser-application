<?php

use Composer\Script\Event;

class ComposerHook
{
    public static function generateConfig(Event $event)
    {
        $red = '\033[0;31m';
        if (!is_file(__DIR__ . "/../build.ini")) {
            $event->getIO()->writeError("<error>File build.ini not found!</error>");
            die;
        }
        $iniArray = parse_ini_file(__DIR__ . "/../build.ini");
        $configTemplateFile = __DIR__ . "/Config/Config.php.dist";
        $configFile = __DIR__ . "/Config/Config.php";
        if (!copy($configTemplateFile, $configFile)) {
            $event->getIO()->writeError("<error>Config file not generated!</error>");
            die;
        }
        $file_contents = file_get_contents($configFile);
        foreach ($iniArray as $name => $value) {
            $file_contents = str_replace("%{$name}%", $value, $file_contents);
        }
        file_put_contents($configFile, $file_contents);
    }
}
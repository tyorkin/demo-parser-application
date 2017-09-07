<?php

namespace Tyorkin\HyperParserApplication\Log;


class UrlConsoleLog implements ConsoleLogInterface
{
    const MASK = "|%-100.100s |%-14.14s |%-20.20s |%-11.11s |%-11.11s |%-9.9s |%-15.15s |%-26.26s |%-18.18s |\n";

    public function write($data)
    {
        if (!is_array($data) || count($data) != 10) {
            print_r($data);
            return;
        }
        foreach ($data as $key => $field) {
            if (is_bool($field)) {
                $data[$key] = $field ? 'yes' : 'no';
            }
        }
        printf(self::MASK, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[9]);
    }

    public function startWrite()
    {
        echo(str_repeat('-', 243)."\n");
    }

    public function endWrite()
    {
        $this->startWrite();
    }


}
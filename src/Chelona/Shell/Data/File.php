<?php

namespace Chelona\Shell\Data;

class File
{
    public static function mapOverFile(string $fileName, callable $callback, bool $shouldTrim = true): void
    {
        $file = fopen($fileName, 'r');
        while ($line = fgets($file)) {
            if($shouldTrim) {
                $line = trim($line);
            }
            $callback($line);
        }
        fclose($file);
    }

    public static function read(string $fileName): string
    {
        return file_get_contents($fileName);
    }

    public static function readAsMatrix(string $fileName): array
    {
        $output = [];
        File::mapOverFile($fileName, function ($line) use (&$output) {
            $output[] = str_split($line);
        });

        return $output;
    }

    public static function characterCounts(string $fileName): array
    {
        $output = [];
        File::mapOverFile($fileName, function ($line) use (&$output) {
            foreach (str_split($line) as $char) {
                if (!isset($output[$char])) {
                    $output[$char] = 0;
                }
                $output[$char]++;
            }
        });

        return $output;
    }
}

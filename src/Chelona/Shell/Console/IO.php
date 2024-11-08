<?php

namespace Chelona\Shell\Console;

final class IO {
    public static function read(): string
    {
        return trim(fgets(STDIN));
    }

    public static function write(string $message, bool $newLine = true): void
    {
        if ($newLine) {
            $message .= "\n";
        }
        fwrite(STDOUT, $message);
    }
}

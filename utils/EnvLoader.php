<?php
namespace Utils;

class EnvLoader {
    public static function loadEnv(): void {
        if (file_exists(__DIR__ . '/../.env')) {
            $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                [$name, $value] = explode('=', $line, 2);
                $_ENV[$name] = $value;
            }
        }
    }
}
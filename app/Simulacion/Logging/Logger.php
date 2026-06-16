<?php

namespace App\Simulacion\Logging;

class Logger
{
    private bool $verbose;

    public function __construct(bool $verbose = false)
    {
        $this->verbose = $verbose;
    }

    public function log(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function info(string $message): void
    {
        echo "ℹ️ {$message}" . PHP_EOL;
    }

    public function success(string $message): void
    {
        echo "✅ {$message}" . PHP_EOL;
    }

    public function error(string $message): void
    {
        echo "❌ {$message}" . PHP_EOL;
    }

    public function warn(string $message): void
    {
        echo "⚠️ {$message}" . PHP_EOL;
    }

    public function verboseLog(string $message): void
    {
        if ($this->verbose) {
            echo "   {$message}" . PHP_EOL;
        }
    }

    public function section(string $title): void
    {
        echo PHP_EOL . str_repeat('=', 70) . PHP_EOL;
        echo $title . PHP_EOL;
        echo str_repeat('=', 70) . PHP_EOL;
    }

    public function subSection(string $title): void
    {
        echo PHP_EOL . "📌 {$title}" . PHP_EOL;
    }
}
<?php
declare(strict_types = 1);

namespace Salmon\Io;

final class EchoWriter implements Writer
{
    /** @var ?EchoWriter */
    private static $instance;

    private function __construct()
    {
    }

    public static function instance(): EchoWriter
    {
        if (self::$instance === NULL)
        {
            self::$instance = new EchoWriter();
        }
        return self::$instance;
    }

    public function write(string $buffer): void
    {
        echo $buffer;
    }

    public function flush(): void
    {
        \flush();
    }
}

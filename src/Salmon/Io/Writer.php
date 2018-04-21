<?php
declare(strict_types = 1);

namespace Salmon\Io;

interface Writer
{
    public function write(string $buffer): void;

    public function flush(): void;
}

<?php
declare(strict_types = 1);

namespace Salmon;

final class SourceLocation
{
    /** @var string */
    public $filename;

    /** @var int */
    public $line;

    /** @var int */
    public $column;

    public function __construct(string $filename, int $line, int $column)
    {
        $this->filename = $filename;
        $this->line = $line;
        $this->column = $column;
    }

    public function advance(string $character): void
    {
        if ($character === "\n")
        {
            ++$this->line;
            $this->column = 1;
        }
        else
        {
            ++$this->column;
        }
    }
}

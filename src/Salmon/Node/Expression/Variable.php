<?php
declare(strict_types = 1);

namespace Salmon\Node\Expression;

use Salmon\Generate;
use Salmon\Io\Writer;
use Salmon\Node\Expression;
use Salmon\SourceLocation;

final class Variable extends Expression
{
    /** @var string */
    public $name;

    public function __construct(SourceLocation $sourceLocation,
                                string $name)
    {
        parent::__construct($sourceLocation);
        $this->name = $name;
    }

    /**
     * @return array<string, NULL>
     */
    public function freeVariables(): array
    {
        return [$this->name => NULL];
    }

    public function generate(Generate $generate, Writer $writer): string
    {
        return '$' . $this->name;
    }
}

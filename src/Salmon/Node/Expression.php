<?php
declare(strict_types = 1);

namespace Salmon\Node;

use Salmon\Generate;
use Salmon\Io\Writer;
use Salmon\Node;
use Salmon\SourceLocation;

abstract class Expression extends Node
{
    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct($sourceLocation);
    }

    /**
     * Return the set of variables that this expression needs to be in scope in
     * order for evaluation to succeed.
     *
     * @return array<string, NULL>
     */
    public abstract function freeVariables(): array;

    /**
     * Generate PHP statements for the expression, and return a PHP expression
     * to retrieve the result.
     */
    public abstract function generate(Generate $generate, Writer $writer): string;
}

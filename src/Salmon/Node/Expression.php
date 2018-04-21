<?php
declare(strict_types = 1);

namespace Salmon\Node;

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
}

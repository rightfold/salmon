<?php
declare(strict_types = 1);

namespace Salmon\Node;

use Salmon\Generate;
use Salmon\Node;
use Salmon\SourceLocation;

abstract class Type extends Node
{
    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct($sourceLocation);
    }

    /**
     * Generate the type annotation to be put in the documentation comment for
     * the parameter or return type.
     */
    public abstract function generateTypeAnnotation(Generate $generate): string;

    /**
     * Generate the type hint to be put in the parameter or return type.
     */
    public abstract function generateTypeHint(Generate $generate): string;
}

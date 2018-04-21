<?php
declare(strict_types = 1);

namespace Salmon\Node;

use Salmon\Node;
use Salmon\SourceLocation;

abstract class Type extends Node
{
    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct($sourceLocation);
    }

    public abstract function phpPhpStanType(): string;

    public abstract function toPsalmType(): string;

    public abstract function toTypeHint(): string;
}

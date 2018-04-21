<?php
declare(strict_types = 1);

namespace Salmon;

abstract class Node
{
    /** @var SourceLocation */
    public $sourceLocation;

    public function __construct(SourceLocation $sourceLocation)
    {
        $this->sourceLocation = $sourceLocation;
    }
}

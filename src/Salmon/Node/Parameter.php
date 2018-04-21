<?php
declare(strict_types = 1);

namespace Salmon\Node;

use Salmon\Node;
use Salmon\SourceLocation;

final class Parameter extends Node
{
    /** @var string */
    public $name;

    /** @var Type */
    public $type;

    public function __construct(SourceLocation $sourceLocation,
                                string $name,
                                Type $type)
    {
        parent::__construct($sourceLocation);
        $this->name = $name;
        $this->type = $type;
    }
}

<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use Salmon\SourceLocation;

use Exception;

class ParseException extends Exception
{
    /** @var SourceLocation */
    public $sourceLocation;

    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct(\get_class($this));
        $this->sourceLocation = $sourceLocation;
    }
}

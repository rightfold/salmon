<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use Salmon\SourceLocation;

class InvalidParseException extends ParseException
{
    /** @var string */
    public $rule;

    public function __construct(SourceLocation $sourceLocation,
                                string $rule)
    {
        parent::__construct($sourceLocation);
        $this->rule = $rule;
    }
}

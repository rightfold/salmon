<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use Salmon\SourceLocation;

class InvalidLexemeException extends ParseException
{
    /** @var string */
    public $remainingText;

    public function __construct(SourceLocation $sourceLocation,
                                string $remainingText)
    {
        parent::__construct($sourceLocation);
        $this->remainingText = $remainingText;
    }
}

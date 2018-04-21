<?php
declare(strict_types = 1);

namespace Salmon\Node\Type;

use Salmon\Generate;
use Salmon\Node\Type;
use Salmon\SourceLocation;

final class String_ extends Type
{
    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct($sourceLocation);
    }

    public function generateTypeAnnotation(Generate $generate): string
    {
        return 'string';
    }

    public function generateTypeHint(Generate $generate): string
    {
        return 'string';
    }
}

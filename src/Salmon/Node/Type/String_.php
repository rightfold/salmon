<?php
declare(strict_types = 1);

namespace Salmon\Node\Type;

use Salmon\Node\Type;
use Salmon\SourceLocation;

final class String_ extends Type
{
    public function __construct(SourceLocation $sourceLocation)
    {
        parent::__construct($sourceLocation);
    }

    public function phpPhpStanType(): string
    {
        return 'string';
    }

    public function toPsalmType(): string
    {
        return 'string';
    }

    public function toTypeHint(): string
    {
        return 'string';
    }
}

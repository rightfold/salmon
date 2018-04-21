<?php
declare(strict_types = 1);

namespace Salmon\Node\Expression;

use Salmon\Generate;
use Salmon\Io\Writer;
use Salmon\Node\Expression;
use Salmon\Node\Type;
use Salmon\SourceLocation;

final class Cast extends Expression
{
    /** @var Expression */
    public $value;

    /** @var Type */
    public $type;

    /**
     * @param array<Parameter> $parameters
     */
    public function __construct(SourceLocation $sourceLocation,
                                Expression $value,
                                Type $type)
    {
        parent::__construct($sourceLocation);
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @return array<string, NULL>
     */
    public function freeVariables(): array
    {
        return $this->value->freeVariables();
    }

    public function generate(Generate $generate, Writer $writer): string
    {
        $value = $this->value->generate($generate, $writer);
        $type = $this->type->generateTypeHint($generate);
        return '((' . $type . ')' . $value . ')';
    }
}

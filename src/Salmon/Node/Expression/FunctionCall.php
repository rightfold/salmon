<?php
declare(strict_types = 1);

namespace Salmon\Node\Expression;

use Salmon\Generate;
use Salmon\Io\Writer;
use Salmon\Node\Expression;
use Salmon\SourceLocation;

final class FunctionCall extends Expression
{
    /** @var Expression */
    public $function;

    /** @var array<Expression> */
    public $arguments;

    /**
     * @param array<Expression> $arguments
     */
    public function __construct(SourceLocation $sourceLocation,
                                Expression $function,
                                array $arguments)
    {
        parent::__construct($sourceLocation);
        $this->function = $function;
        $this->arguments = $arguments;
    }

    /**
     * @return array<string, NULL>
     */
    public function freeVariables(): array
    {
        $freeVariables = [];

        $freeVariables = \array_merge($freeVariables, $this->function->freeVariables());

        foreach ($this->arguments as $argument)
        {
            $freeVariables = \array_merge($freeVariables, $argument->freeVariables());
        }

        return $freeVariables;
    }

    public function generate(Generate $generate, Writer $writer): string
    {
        $function = $this->function->generate($generate, $writer);

        $arguments = [];
        foreach ($this->arguments as $argument)
        {
            $arguments[] = $argument->generate($generate, $writer);
        }

        return $function . '(' . \implode(', ', $arguments) . ')';
    }
}

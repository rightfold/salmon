<?php
declare(strict_types = 1);

namespace Salmon\Node\Expression;

use Salmon\Node\Expression;
use Salmon\Node\Parameter;
use Salmon\SourceLocation;

final class Lambda extends Expression
{
    /** @var array<Parameter> */
    public $parameters;

    /** @var Expression */
    public $body;

    /**
     * @param array<Parameter> $parameters
     */
    public function __construct(SourceLocation $sourceLocation,
                                array $parameters,
                                Expression $body)
    {
        parent::__construct($sourceLocation);
        $this->parameters = $parameters;
        $this->body = $body;
    }

    /**
     * @return array<string, NULL>
     */
    public function freeVariables(): array
    {
        $freeVariables = $this->body->freeVariables();
        foreach ($this->parameters as $parameter)
        {
            unset($freeVariables[$parameter->name]);
        }
        return $freeVariables;
    }
}

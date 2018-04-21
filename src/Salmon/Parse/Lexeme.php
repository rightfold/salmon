<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use Salmon\SourceLocation;

final class Lexeme
{
    public const T_EOF         = 0;
    public const T_PUNCTUATION = 1;
    public const T_KEYWORD     = 2;
    public const T_IDENTIFIER  = 3;

    /** @var SourceLocation */
    public $sourceLocation;

    /** @var int */
    public $token;

    /** @var string */
    public $value;

    public function __construct(SourceLocation $sourceLocation,
                                int $token,
                                string $value)
    {
        $this->sourceLocation = $sourceLocation;
        $this->token = $token;
        $this->value = $value;
    }

    public function isKeyword(string $keyword): bool
    {
        return
            $this->token === Lexeme::T_KEYWORD &&
            $this->value === $keyword;
    }

    public function isPunctuation(string $punctuation): bool
    {
        return
            $this->token === Lexeme::T_PUNCTUATION &&
            $this->value === $punctuation;
    }
}

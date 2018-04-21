<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use Salmon\SourceLocation;

final class Lexer
{
    /** @var string */
    private $remainingText;

    /** @var SourceLocation */
    private $sourceLocation;

    public function __construct(string $filename,
                                string $text)
    {
        $this->remainingText = $text;
        $this->sourceLocation = new SourceLocation($filename, 1, 1);
    }

    public function __clone()
    {
        $this->sourceLocation = clone $this->sourceLocation;
    }

    public function lex(): Lexeme
    {
        $this->skipWhitespace();

        $character = $this->read();

        if ($character === NULL)
        {
            return $this->makeLexeme(Lexeme::T_EOF, '');
        }

        if (self::isIdentifierHead($character))
        {
            $name = $character;
            for (;;)
            {
                $character = $this->peek();
                if ($character === NULL || !self::isIdentifierTail($character))
                {
                    break;
                }
                $this->read();
                $name .= (string)$character;
            }
            switch ($name) {
            case 'as':
            case 'end':
            case 'fun':
            case 'fun':
            case 'is':
            case 'module':
            case 'string':
                $token = Lexeme::T_KEYWORD;
                break;
            default:
                $token = Lexeme::T_IDENTIFIER;
                break;
            }
            return $this->makeLexeme($token, $name);
        }

        switch ($character)
        {
        case '(':
        case ')':
        case ',':
            return $this->makeLexeme(Lexeme::T_PUNCTUATION, $character);
        }

        throw new InvalidLexemeException($this->sourceLocation,
                                         $this->remainingText);
    }

    private function peek(): ?string
    {
        if ($this->remainingText === '')
        {
            return NULL;
        }

        return $this->remainingText[0];
    }

    private function read(): ?string
    {
        if ($this->remainingText === '')
        {
            return NULL;
        }

        $character = $this->remainingText[0];
        $this->remainingText = \substr($this->remainingText, 1);

        $this->sourceLocation->advance($character);

        return $character;
    }

    private function makeLexeme(int $token, string $value): Lexeme
    {
        return new Lexeme($this->sourceLocation, $token, $value);
    }

    private function skipWhitespace(): void
    {
        for (;;)
        {
            $character = $this->peek();
            if ($character !== ' ' && $character !== "\n")
            {
                break;
            }
            $this->read();
        }
    }

    private static function isIdentifierHead(string $character): bool
    {
        return
            (\strcmp($character, 'a') >= 0 && \strcmp($character, 'z') <= 0) ||
            (\strcmp($character, 'A') >= 0 && \strcmp($character, 'Z') <= 0);
    }

    private static function isIdentifierTail(string $character): bool
    {
        return self::isIdentifierHead($character);
    }
}

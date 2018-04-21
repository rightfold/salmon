<?php
declare(strict_types = 1);

namespace Salmon\Parse;

use PHPUnit\Framework\TestCase;

final class LexerTest extends TestCase
{
    private const EXAMPLE_FILENAME = 'example.sal';

    public function __construct()
    {
        parent::__construct();
        $this->backupGlobals = FALSE;
        $this->backupStaticAttributes = FALSE;
        $this->runTestInSeparateProcess = FALSE;
    }

    public function testEmpty(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '');
        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_EOF, $lexeme->token);
    }

    public function testIdentifier(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, 'example');
        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_IDENTIFIER, $lexeme->token);
        $this->assertSame('example', $lexeme->value);
    }

    public function testKeyword(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, 'fun');
        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_KEYWORD, $lexeme->token);
        $this->assertSame('fun', $lexeme->value);
    }

    public function testPunctuation(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '(),');

        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_PUNCTUATION, $lexeme->token);
        $this->assertSame('(', $lexeme->value);

        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_PUNCTUATION, $lexeme->token);
        $this->assertSame(')', $lexeme->value);

        $lexeme = $lexer->lex();
        $this->assertSame(Lexeme::T_PUNCTUATION, $lexeme->token);
        $this->assertSame(',', $lexeme->value);
    }
}

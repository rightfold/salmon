<?php
declare(strict_types = 1);

namespace Salmon;

use Salmon\Parse\Lexer;

use PHPUnit\Framework\TestCase;

final class ParseTest extends TestCase
{
    private const EXAMPLE_FILENAME = 'example.sal';

    public function __construct()
    {
        parent::__construct();
        $this->backupGlobals = FALSE;
        $this->backupStaticAttributes = FALSE;
        $this->runTestInSeparateProcess = FALSE;
    }

    public function testParseExpressionCast(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '
            x as string
        ');
        $expression = Parse::parseExpression($lexer);
        \var_dump($expression);
    }

    public function testParseExpressionFunctionCall(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '
            x(y, z)
        ');
        $expression = Parse::parseExpression($lexer);
        \var_dump($expression);
    }

    public function testParseExpressionLambda(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '
            fun(x string, y string) is x end
        ');
        $expression = Parse::parseExpression($lexer);
        \var_dump($expression);
    }

    public function testParseExpressionVariable(): void
    {
        $lexer = new Lexer(self::EXAMPLE_FILENAME, '
            x
        ');
        $expression = Parse::parseExpression($lexer);
        \var_dump($expression);
    }
}

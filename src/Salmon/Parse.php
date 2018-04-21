<?php
declare(strict_types = 1);

namespace Salmon;

use Salmon\Node\Expression;
use Salmon\Node\Parameter;
use Salmon\Node\Type;
use Salmon\Parse\InvalidParseException;
use Salmon\Parse\Lexeme;
use Salmon\Parse\Lexer;

final class Parse
{
    private function __construct()
    {
    }

    public static function parseExpression(Lexer $lexer): Expression
    {
        return self::parseExpression1($lexer);
    }

    public static function parseExpression1(Lexer $lexer): Expression
    {
        $expression = self::parseExpression2($lexer);

        for (;;)
        {
            $initialPostfixLexeme = (clone $lexer)->lex();

            if ($initialPostfixLexeme->isKeyword('as'))
            {
                $lexer->lex();
                $type = self::parseType($lexer);
                $expression = new Expression\Cast($expression->sourceLocation,
                                                  $expression, $type);
                continue;
            }

            break;
        }

        return $expression;
    }

    public static function parseExpression2(Lexer $lexer): Expression
    {
        $expression = self::parseExpression3($lexer);

        for (;;)
        {
            $initialPostfixLexeme = (clone $lexer)->lex();

            if ($initialPostfixLexeme->isPunctuation('('))
            {
                $arguments = self::parseArguments($lexer);
                $expression = new Expression\FunctionCall($expression->sourceLocation,
                                                          $expression, $arguments);
                continue;
            }

            break;
        }

        return $expression;
    }

    public static function parseExpression3(Lexer $lexer): Expression
    {
        $lexeme = $lexer->lex();

        if ($lexeme->token === Lexeme::T_IDENTIFIER)
        {
            return new Expression\Variable($lexeme->sourceLocation,
                                           $lexeme->value);
        }

        if ($lexeme->isKeyword('fun'))
        {
            $parameters = self::parseParameters($lexer);
            self::assertKeyword($lexer, 'is');
            $body = self::parseExpression($lexer);
            self::assertKeyword($lexer, 'end');
            return new Expression\Lambda($lexeme->sourceLocation,
                                         $parameters, $body);
        }

        throw new InvalidParseException($lexeme->sourceLocation, 'Expression');
    }

    public static function parseType(Lexer $lexer): Type
    {
        $lexeme = $lexer->lex();

        if ($lexeme->isKeyword('string'))
        {
            return new Type\String_($lexeme->sourceLocation);
        }

        throw new InvalidParseException($lexeme->sourceLocation, 'Type');
    }

    /**
     * @return array<Expression>
     */
    public static function parseArguments(Lexer $lexer): array
    {
        $arguments = [];
        self::assertPunctuation($lexer, '(');
        for ($first = TRUE; ; $first = FALSE)
        {
            if ((clone $lexer)->lex()->isPunctuation(')'))
            {
                $lexer->lex();
                break;
            }

            if (!$first)
            {
                self::assertPunctuation($lexer, ',');
            }

            $arguments[] = self::parseExpression($lexer);
        }
        return $arguments;
    }

    /**
     * @return array<Parameter>
     */
    public static function parseParameters(Lexer $lexer): array
    {
        $parameters = [];
        self::assertPunctuation($lexer, '(');
        for ($first = TRUE; ; $first = FALSE)
        {
            if ((clone $lexer)->lex()->isPunctuation(')'))
            {
                $lexer->lex();
                break;
            }

            if (!$first)
            {
                self::assertPunctuation($lexer, ',');
            }

            $parameters[] = self::parseParameter($lexer);
        }
        return $parameters;
    }

    public static function parseParameter(Lexer $lexer): Parameter
    {
        $name = self::assertIdentifier($lexer);
        $type = self::parseType($lexer);
        return new Parameter($name->sourceLocation, $name->value, $type);
    }

    public static function assertIdentifier(Lexer $lexer): Lexeme
    {
        $lexeme = $lexer->lex();
        if ($lexeme->token !== Lexeme::T_IDENTIFIER)
        {
            throw new InvalidParseException($lexeme->sourceLocation,
                                            'Identifier');
        }
        return $lexeme;
    }

    public static function assertKeyword(Lexer $lexer, string $keyword): void
    {
        $lexeme = $lexer->lex();
        if (!$lexeme->isKeyword($keyword))
        {
            throw new InvalidParseException($lexeme->sourceLocation,
                                            "Keyword '$keyword'");
        }
    }

    public static function assertPunctuation(Lexer $lexer, string $punctuation): void
    {
        $lexeme = $lexer->lex();
        if (!$lexeme->isPunctuation($punctuation))
        {
            throw new InvalidParseException($lexeme->sourceLocation,
                                            "Punctuation '$punctuation'");
        }
    }
}

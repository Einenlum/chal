<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * I think my DLQ skiils have reached some limits here…
 * let be honest ¯\\_(ツ)_/¯ :
 */
final class STDistanceSphere extends FunctionNode
{
    private $point1;
    private $point2;

    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->point1 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->point2 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $point1 = $this->point1->dispatch($sqlWalker);
        $point2 = $this->point2->dispatch($sqlWalker);

        return sprintf('ST_Distance(%s, %s)', $point1, $point2);
    }
}

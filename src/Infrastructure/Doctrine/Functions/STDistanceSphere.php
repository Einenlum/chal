<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 * STDistanceSphereFunction ::= "ST_Distance_Sphere" "(" FirstPoint "," SecondPoint ")"
 */
final class STDistanceSphere extends FunctionNode
{
    public $point1;
    public $point2;

    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->geomExpr[] = $parser->ArithmeticPrimary();
        while (count($this->geomExpr) < 2 || ((2 === null || count($this->geomExpr) < 2) && $lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS)) {
            $parser->match(Lexer::T_COMMA);
            $this->geomExpr[] = $parser->ArithmeticPrimary();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $arguments = array();
        foreach ($this->geomExpr as $expression) {
            $arguments[] = $expression->dispatch($sqlWalker);
        }

        return sprintf('ST_Distance(%s)', implode(', ', $arguments));
    }
}

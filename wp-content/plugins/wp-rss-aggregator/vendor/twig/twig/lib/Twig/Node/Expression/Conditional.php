<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

class Twig_Node_Expression_Conditional extends AbstractExpression
{
    public function __construct(AbstractExpression $expr1, AbstractExpression $expr2, AbstractExpression $expr3, $lineno)
    {
        parent::__construct(['expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3], [], $lineno);
    }

    public function compile(Compiler $compiler)
    {
        $compiler
            ->raw('((')
            ->subcompile($this->getNode('expr1'))
            ->raw(') ? (')
            ->subcompile($this->getNode('expr2'))
            ->raw(') : (')
            ->subcompile($this->getNode('expr3'))
            ->raw('))')
        ;
    }
}

class_alias('Twig_Node_Expression_Conditional', 'Twig\Node\Expression\ConditionalExpression', false);

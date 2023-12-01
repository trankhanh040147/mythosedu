<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WCML\Twig\Node\Expression;

use WCML\Twig\Compiler;
class ArrayExpression extends \WCML\Twig\Node\Expression\AbstractExpression
{
    protected $index;
    public function __construct(array $elements, $lineno)
    {
        parent::__construct($elements, [], $lineno);
        $this->index = -1;
        foreach ($this->getKeyValuePairs() as $pair) {
            if ($pair['key'] instanceof \WCML\Twig\Node\Expression\ConstantExpression && \ctype_digit((string) $pair['key']->getAttribute('value')) && $pair['key']->getAttribute('value') > $this->index) {
                $this->index = $pair['key']->getAttribute('value');
            }
        }
    }
    public function getKeyValuePairs()
    {
        $pairs = [];
        foreach (\array_chunk($this->nodes, 2) as $pair) {
            $pairs[] = ['key' => $pair[0], 'value' => $pair[1]];
        }
        return $pairs;
    }
    public function hasElement(\WCML\Twig\Node\Expression\AbstractExpression $key)
    {
        foreach ($this->getKeyValuePairs() as $pair) {
            // we compare the string representation of the keys
            // to avoid comparing the line numbers which are not relevant here.
            if ((string) $key === (string) $pair['key']) {
                return \true;
            }
        }
        return \false;
    }
    public function addElement(\WCML\Twig\Node\Expression\AbstractExpression $value, \WCML\Twig\Node\Expression\AbstractExpression $key = null)
    {
        if (null === $key) {
            $key = new \WCML\Twig\Node\Expression\ConstantExpression(++$this->index, $value->getTemplateLine());
        }
        \array_push($this->nodes, $key, $value);
    }
    public function compile(\WCML\Twig\Compiler $compiler)
    {
        $compiler->raw('[');
        $first = \true;
        foreach ($this->getKeyValuePairs() as $pair) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $first = \false;
            $compiler->subcompile($pair['key'])->raw(' => ')->subcompile($pair['value']);
        }
        $compiler->raw(']');
    }
}
\class_alias('WCML\\Twig\\Node\\Expression\\ArrayExpression', 'WCML\\Twig_Node_Expression_Array');

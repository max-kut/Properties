<?php
/**
 * This file is part of Properties package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Serafim\Properties\Attribute;

/**
 * Class Conjunction
 */
class Conjunction implements Matchable
{
    /**
     * @var array|Matchable[]
     */
    protected $matchable = [];

    /**
     * OrTypeHint constructor.
     * @param Matchable $matcher
     */
    public function __construct(Matchable $matcher)
    {
        $this->addMatcher($matcher);
    }

    /**
     * @param Matchable $matcher
     * @return Disjunction
     */
    public function addMatcher(Matchable $matcher): Matchable
    {
        if ($matcher instanceof self) {
            $this->matchable = \array_merge($this->matchable, $matcher->matchable);
        } else {
            $this->matchable[] = $matcher;
        }

        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function match($value): bool
    {
        foreach ($this->matchable as $matcher) {
            if (! $matcher->match($value)) {
                return false;
            }
        }

        return true;
    }
}

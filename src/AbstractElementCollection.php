<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

abstract class AbstractElementCollection implements \Countable, \Iterator, WebDriverElementCollectionInterface
{
    /**
     * @var WebDriverElement[]
     */
    private array $elements = [];
    private int $iteratorPosition = 0;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if ($element instanceof WebDriverElement && $this->canBeAdded($element)) {
                $this->elements[] = $element;
            }
        }
    }

    abstract protected function canBeAdded(WebDriverElement $element): bool;

    public function get(int $index): ?WebDriverElement
    {
        return $this->elements[$index] ?? null;
    }

    // Countable methods

    public function count(): int
    {
        return count($this->elements);
    }

    // Iterator methods

    public function rewind()
    {
        $this->iteratorPosition = 0;
    }

    public function current(): WebDriverElement
    {
        return $this->elements[$this->iteratorPosition];
    }

    public function key(): int
    {
        return $this->iteratorPosition;
    }

    public function next()
    {
        ++$this->iteratorPosition;
    }

    public function valid(): bool
    {
        return isset($this->elements[$this->iteratorPosition]);
    }
}

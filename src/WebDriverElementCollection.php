<?php

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

class WebDriverElementCollection implements \Countable, \Iterator, WebDriverElementCollectionInterface
{
    /**
     * @var WebDriverElement[]
     */
    private $elements = [];
    private $iteratorPosition = 0;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if ($element instanceof WebDriverElement) {
                $this->elements[] = $element;
            }
        }
    }

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

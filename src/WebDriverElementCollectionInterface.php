<?php

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

interface WebDriverElementCollectionInterface extends \Countable, \Iterator
{
    public function get(int $index): ?WebDriverElement;
    public function current(): WebDriverElement;
}

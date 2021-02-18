<?php

declare(strict_types=1);

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

class WebDriverElementCollection extends AbstractElementCollection
{
    protected function canBeAdded(WebDriverElement $element): bool
    {
        return $element instanceof WebDriverElement;
    }
}

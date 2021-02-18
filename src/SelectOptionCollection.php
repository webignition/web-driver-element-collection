<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;

class SelectOptionCollection extends AbstractElementCollection
{
    /**
     * @param WebDriverElement[] $webDriverElements
     */
    public static function is(array $webDriverElements): bool
    {
        if (0 === count($webDriverElements)) {
            return false;
        }

        foreach ($webDriverElements as $element) {
            if (!$element instanceof WebDriverElement) {
                return false;
            }

            if (false === self::isOptionElement($element)) {
                return false;
            }
        }

        return true;
    }

    public static function fromSelectElement(WebDriverElement $element): ?SelectOptionCollection
    {
        if ('select' !== $element->getTagName()) {
            return null;
        }

        return new SelectOptionCollection(
            $element->findElements(WebDriverBy::tagName('option'))
        );
    }

    protected function canBeAdded(WebDriverElement $element): bool
    {
        return self::isOptionElement($element);
    }

    private static function isOptionElement(WebDriverElement $element): bool
    {
        return 'option' === $element->getTagName();
    }
}

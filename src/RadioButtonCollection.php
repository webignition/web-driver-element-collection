<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

class RadioButtonCollection extends AbstractElementCollection
{
    const REQUIRED_TAG_NAME = 'input';
    const REQUIRED_TYPE = 'radio';
    const NAME_ATTRIBUTE = 'name';
    const TYPE_ATTRIBUTE = 'type';
    private string $name = '';

    /**
     * @param WebDriverElement[] $webDriverElements
     */
    public static function is(array $webDriverElements): bool
    {
        if (0 === count($webDriverElements)) {
            return false;
        }

        $collectionName = '';

        foreach ($webDriverElements as $index => $element) {
            if (!$element instanceof WebDriverElement) {
                return false;
            }

            if (false === self::isRadioButtonElement($element)) {
                return false;
            }

            $elementName = (string) $element->getAttribute(self::NAME_ATTRIBUTE);

            if (0 === $index) {
                $collectionName = $elementName;
            }

            if ($elementName !== $collectionName) {
                return false;
            }
        }

        return true;
    }

    protected function canBeAdded(WebDriverElement $element): bool
    {
        if (!self::isRadioButtonElement($element)) {
            return false;
        }

        $name = (string) $element->getAttribute(self::NAME_ATTRIBUTE);

        if (0 === count($this)) {
            $this->name = $name;
        }

        return $name === $this->name;
    }

    private static function isRadioButtonElement(WebDriverElement $element): bool
    {
        if (self::REQUIRED_TAG_NAME !== $element->getTagName()) {
            return false;
        }

        $type = (string) $element->getAttribute(self::TYPE_ATTRIBUTE);
        if (self::REQUIRED_TYPE !== $type) {
            return false;
        }

        $name = (string) $element->getAttribute(self::NAME_ATTRIBUTE);
        if ('' === $name) {
            return false;
        }

        return true;
    }
}

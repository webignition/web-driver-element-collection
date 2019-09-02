<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection;

use Facebook\WebDriver\WebDriverElement;

class RadioButtonCollection extends AbstractElementCollection
{
    const REQUIRED_TAG_NAME = 'input';
    const REQUIRED_TYPE = 'radio';
    const NAME_ATTRIBUTE = 'name';
    const TYPE_ATTRIBUTE = 'type';
    private $name = '';

    protected function canBeAdded(WebDriverElement $element): bool
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

        if (0 === count($this)) {
            $this->name = $name;
        }

        return $name === $this->name;
    }
}

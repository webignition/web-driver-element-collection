<?php
/** @noinspection PhpIncompatibleReturnTypeInspection */
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Services;

use Facebook\WebDriver\WebDriverElement;

class ElementFactory
{
    public static function createRadio(string $name): WebDriverElement
    {
        return self::create(
            'input',
            [
                'type' => 'radio',
                'name' => $name,
            ]
        );
    }

    public static function create(string $tagName, array $attributes = []): WebDriverElement
    {
        $element = \Mockery::mock(WebDriverElement::class);

        $element
            ->shouldReceive('getTagName')
            ->andReturn($tagName);

        foreach ($attributes as $name => $value) {
            $element
                ->shouldReceive('getAttribute')
                ->with($name)
                ->andReturn($value);
        }

        return $element;
    }
}

<?php

declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Services;

use Facebook\WebDriver\WebDriverElement;
use Mockery\MockInterface;

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

    /**
     * @param string $tagName
     * @param array $attributes
     *
     * @return WebDriverElement|MockInterface
     */
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

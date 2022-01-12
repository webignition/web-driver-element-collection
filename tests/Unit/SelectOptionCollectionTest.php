<?php

declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\SelectOptionCollection;
use webignition\WebDriverElementCollection\Tests\Services\ElementFactory;

class SelectOptionCollectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider createDataProvider
     *
     * @param WebDriverElement[] $elements
     */
    public function testCreate(array $elements, SelectOptionCollection $expectedCollection): void
    {
        $collection = new SelectOptionCollection($elements);

        $this->assertEquals($expectedCollection, $collection);
    }

    /**
     * @return array<mixed>
     */
    public function createDataProvider(): array
    {
        $input = ElementFactory::create('input');
        $option1 = ElementFactory::create('option');
        $option2 = ElementFactory::create('option');

        return [
            'empty' => [
                'elements' => [],
                'expectedCollection' => new SelectOptionCollection(),
            ],
            'non-valid values' => [
                'elements' => [
                    1,
                    true,
                    'string',
                ],
                'expectedCollection' => new SelectOptionCollection(),
            ],
            'valid values' => [
                'elements' => [
                    $input,
                    $option1,
                    $option2,
                ],
                'expectedCollection' => new SelectOptionCollection([
                    $option1,
                    $option2,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider isDataProvider
     *
     * @param WebDriverElement[] $webDriverElements
     */
    public function testIs(array $webDriverElements, bool $expectedIs): void
    {
        $this->assertSame(SelectOptionCollection::is($webDriverElements), $expectedIs);
    }

    /**
     * @return array<mixed>
     */
    public function isDataProvider(): array
    {
        return [
            'empty' => [
                'webDriverElements' => [],
                'expectedIs' => false,
            ],
            'singular, not WebDriverElement instance' => [
                'webDriverElements' => [
                    new \stdClass(),
                ],
                'expectedIs' => false,
            ],
            'singular, tag name not option' => [
                'webDriverElements' => [
                    ElementFactory::create('p'),
                ],
                'expectedIs' => false,
            ],
            'singular, valid' => [
                'webDriverElements' => [
                    ElementFactory::create('option'),
                ],
                'expectedIs' => true,
            ],
            'multiple, first valid, second not valid' => [
                'webDriverElements' => [
                    ElementFactory::create('option'),
                    ElementFactory::create('p'),
                ],
                'expectedIs' => false,
            ],
            'multiple, valid' => [
                'webDriverElements' => [
                    ElementFactory::create('option'),
                    ElementFactory::create('option'),
                ],
                'expectedIs' => true,
            ],
        ];
    }

    /**
     * @dataProvider fromSelectElementDataProvider
     */
    public function testFromSelectElement(WebDriverElement $element, ?SelectOptionCollection $expectedCollection): void
    {
        $this->assertEquals(SelectOptionCollection::fromSelectElement($element), $expectedCollection);
    }

    /**
     * @return array<mixed>
     */
    public function fromSelectElementDataProvider(): array
    {
        $emptySelectElement = ElementFactory::create('select');
        $emptySelectElement
            ->shouldReceive('findElements')
            ->andReturn([])
        ;

        $optionElements = [
            ElementFactory::create('option'),
            ElementFactory::create('option'),
            ElementFactory::create('option'),
        ];

        $selectElement = ElementFactory::create('select');
        $selectElement
            ->shouldReceive('findElements')
            ->andReturn($optionElements)
        ;

        return [
            'not a select element' => [
                'element' => ElementFactory::create('p'),
                'expectedCollection' => null,
            ],
            'empty select element' => [
                'element' => $emptySelectElement,
                'expectedCollection' => new SelectOptionCollection(),
            ],
            'non-empty select element' => [
                'element' => $selectElement,
                'expectedCollection' => new SelectOptionCollection($optionElements),
            ],
        ];
    }
}

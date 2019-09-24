<?php
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\RadioButtonCollection;

class RadioButtonCollectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(array $elements, RadioButtonCollection $expectedCollection)
    {
        $collection = new RadioButtonCollection($elements);

        $this->assertEquals($expectedCollection, $collection);
    }

    public function createDataProvider(): array
    {
        $input = \Mockery::mock(WebDriverElement::class);
        $input
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $input
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturnNull();

        $dateInput = \Mockery::mock(WebDriverElement::class);
        $dateInput
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $dateInput
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn('date');

        $namelessRadioInput = \Mockery::mock(WebDriverElement::class);
        $namelessRadioInput
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $namelessRadioInput
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn('radio');

        $namelessRadioInput
            ->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn('');

        $radio1 = \Mockery::mock(WebDriverElement::class);
        $radio1
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $radio1
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn('radio');

        $radio1 = $this->createRadioElement('group-1');
        $radio2 = $this->createRadioElement('group-1');
        $radio3 = $this->createRadioElement('group-2');

        return [
            'empty' => [
                'elements' => [],
                'expectedCollection' => new RadioButtonCollection(),
            ],
            'non-valid values' => [
                'elements' => [
                    1,
                    true,
                    'string',
                    $input,
                    $dateInput,
                    $namelessRadioInput,
                ],
                'expectedCollection' => new RadioButtonCollection(),
            ],
            'valid values' => [
                'elements' => [
                    $radio1,
                    $radio2,
                    $radio3,
                ],
                'expectedCollection' => new RadioButtonCollection([
                    $radio1,
                    $radio2,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider isDataProvider
     */
    public function testIs(array $webDriverElements, bool $expectedIs)
    {
        $this->assertSame(RadioButtonCollection::is($webDriverElements), $expectedIs);
    }

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
            'singular, tag name not input' => [
                'webDriverElements' => [
                    $this->createElement('p'),
                ],
                'expectedIs' => false,
            ],
            'singular, type not radio' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'text',
                        ]
                    ),
                ],
                'expectedIs' => false,
            ],
            'singular, empty name' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => '',
                        ]
                    ),
                ],
                'expectedIs' => false,
            ],
            'singular, valid' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                ],
                'expectedIs' => true,
            ],
            'multiple, first valid, second not radio button' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    $this->createElement('p'),
                ],
                'expectedIs' => false,
            ],
            'multiple, first valid, second has non-matching name' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'name',
                        ]
                    ),
                ],
                'expectedIs' => false,
            ],
            'multiple, valid' => [
                'webDriverElements' => [
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    $this->createElement(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                ],
                'expectedIs' => true,
            ],
        ];
    }

    private function createRadioElement(string $name): WebDriverElement
    {
        $radio = \Mockery::mock(WebDriverElement::class);
        $radio
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $radio
            ->shouldReceive('getAttribute')
            ->with('type')
            ->andReturn('radio');

        $radio
            ->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn($name);

        return $radio;
    }

    private function createElement(string $tagName, array $attributes = []): WebDriverElement
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

<?php
/** @noinspection PhpIncompatibleReturnTypeInspection */
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

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
        $input = $this->createElement('input', ['type' => null]);
        $dateInput = $this->createElement('input', ['type' => 'date']);

        $namelessRadioInput = $this->createElement(
            'input',
            [
                'type' => 'radio',
                'name' => '',
            ]
        );

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
        return $this->createElement(
            'input',
            [
                'type' => 'radio',
                'name' => $name,
            ]
        );
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

<?php
/** @noinspection PhpIncompatibleReturnTypeInspection */
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

use webignition\WebDriverElementCollection\RadioButtonCollection;
use webignition\WebDriverElementCollection\Tests\Services\ElementFactory;

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
        $input = ElementFactory::create('input', ['type' => null]);
        $dateInput = ElementFactory::create('input', ['type' => 'date']);

        $namelessRadioInput = ElementFactory::create(
            'input',
            [
                'type' => 'radio',
                'name' => '',
            ]
        );

        $radio1 = ElementFactory::createRadio('group-1');
        $radio2 = ElementFactory::createRadio('group-1');
        $radio3 = ElementFactory::createRadio('group-2');

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
                    ElementFactory::create('p'),
                ],
                'expectedIs' => false,
            ],
            'singular, type not radio' => [
                'webDriverElements' => [
                    ElementFactory::create(
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
                    ElementFactory::create(
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
                    ElementFactory::create(
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
                    ElementFactory::create(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    ElementFactory::create('p'),
                ],
                'expectedIs' => false,
            ],
            'multiple, first valid, second has non-matching name' => [
                'webDriverElements' => [
                    ElementFactory::create(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    ElementFactory::create(
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
                    ElementFactory::create(
                        'input',
                        [
                            'type' => 'radio',
                            'name' => 'radio-button-name',
                        ]
                    ),
                    ElementFactory::create(
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
}

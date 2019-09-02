<?php
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\SelectOptionCollection;

class SelectOptionCollectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(array $elements, SelectOptionCollection $expectedCollection)
    {
        $collection = new SelectOptionCollection($elements);

        $this->assertEquals($expectedCollection, $collection);
    }

    public function createDataProvider(): array
    {
        $input = \Mockery::mock(WebDriverElement::class);
        $input
            ->shouldReceive('getTagName')
            ->andReturn('input');

        $option1 = \Mockery::mock(WebDriverElement::class);
        $option1
            ->shouldReceive('getTagName')
            ->andReturn('option');

        $option2 = \Mockery::mock(WebDriverElement::class);
        $option2
            ->shouldReceive('getTagName')
            ->andReturn('option');

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
}

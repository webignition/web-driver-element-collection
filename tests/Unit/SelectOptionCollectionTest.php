<?php
/** @noinspection PhpDocSignatureInspection */
declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

use webignition\WebDriverElementCollection\SelectOptionCollection;
use webignition\WebDriverElementCollection\Tests\Services\ElementFactory;

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
}

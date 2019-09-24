<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

use webignition\WebDriverElementCollection\Tests\Services\ElementFactory;
use webignition\WebDriverElementCollection\WebDriverElementCollection;

class WebDriverElementCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testCountable()
    {
        $this->assertCount(0, new WebDriverElementCollection());

        $this->assertCount(1, new WebDriverElementCollection([
            ElementFactory::create(''),
        ]));

        $this->assertCount(2, new WebDriverElementCollection([
            ElementFactory::create(''),
            ElementFactory::create(''),
        ]));
    }

    public function testIterator()
    {
        $elements = [
            ElementFactory::create(''),
            ElementFactory::create(''),
            ElementFactory::create(''),
        ];

        $collection = new WebDriverElementCollection($elements);

        foreach ($collection as $index => $element) {
            $this->assertSame($elements[$index], $element);
        }
    }

    public function testGet()
    {
        $elements = [
            ElementFactory::create(''),
            ElementFactory::create(''),
            ElementFactory::create(''),
        ];

        $collection = new WebDriverElementCollection($elements);

        $this->assertSame($elements[0], $collection->get(0));
        $this->assertSame($elements[1], $collection->get(1));
        $this->assertSame($elements[2], $collection->get(2));
        $this->assertNull($collection->get(4));
    }
}

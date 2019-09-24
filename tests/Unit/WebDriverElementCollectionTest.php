<?php declare(strict_types=1);

namespace webignition\WebDriverElementCollection\Tests\Unit;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\WebDriverElementCollection;

class WebDriverElementCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testCountable()
    {
        $this->assertCount(0, new WebDriverElementCollection());

        $this->assertCount(1, new WebDriverElementCollection([
            \Mockery::mock(WebDriverElement::class),
        ]));

        $this->assertCount(2, new WebDriverElementCollection([
            \Mockery::mock(WebDriverElement::class),
            \Mockery::mock(WebDriverElement::class),
        ]));
    }

    public function testIterator()
    {
        $elements = [
            \Mockery::mock(WebDriverElement::class),
            \Mockery::mock(WebDriverElement::class),
            \Mockery::mock(WebDriverElement::class),
        ];

        $collection = new WebDriverElementCollection($elements);

        foreach ($collection as $index => $element) {
            $this->assertSame($elements[$index], $element);
        }
    }

    public function testGet()
    {
        $elements = [
            \Mockery::mock(WebDriverElement::class),
            \Mockery::mock(WebDriverElement::class),
            \Mockery::mock(WebDriverElement::class),
        ];

        $collection = new WebDriverElementCollection($elements);

        $this->assertSame($elements[0], $collection->get(0));
        $this->assertSame($elements[1], $collection->get(1));
        $this->assertSame($elements[2], $collection->get(2));
        $this->assertNull($collection->get(4));
    }
}

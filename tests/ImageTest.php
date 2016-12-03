<?php declare(strict_types = 1);
/*
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\ImageManipulator;

use Devtronic\ImageManipulator\Color;
use Devtronic\ImageManipulator\FileLoader\BasicFileLoader;
use Devtronic\ImageManipulator\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testConstructor()
    {
        $image = new Image(200, 200);

        $this->assertSame('Devtronic\\ImageManipulator\\Image', get_class($image));
        $this->assertSame(200, $image->getWidth());
        $this->assertSame(200, $image->getHeight());
        $this->assertSame('resource', gettype($image->getImageResource()));
    }

    public function testImageFromFile()
    {
        $imageFile = __DIR__ . '/resources/test.png';

        $width = 10;
        $height = 10;
        $image = Image::createFromFile($imageFile, new BasicFileLoader());

        $this->assertSame('Devtronic\\ImageManipulator\\Image', get_class($image));

        $this->assertSame($width, $image->getWidth());
        $this->assertSame($height, $image->getHeight());
    }

    public function testGetPixel()
    {
        $imageFile = __DIR__ . '/resources/test.png';

        $image = Image::createFromFile($imageFile, new BasicFileLoader());

        // White
        $expected_at_0_0 = new Color(255, 255, 255, 0);
        $color_at_0_0 = $image->getPixel(0, 0);
        $this->assertEquals($expected_at_0_0, $color_at_0_0);

        // Red
        $expected_at_4_0 = new Color(255, 0, 0, 0);
        $color_at_4_0 = $image->getPixel(4, 0);
        $this->assertEquals($expected_at_4_0, $color_at_4_0);

        // Yellow
        $expected_at_9_0 = new Color(255, 255, 0, 0);
        $color_at_9_0 = $image->getPixel(9, 0);
        $this->assertEquals($expected_at_9_0, $color_at_9_0);

        // Green
        $expected_at_9_4 = new Color(0, 255, 0, 0);
        $color_at_9_4 = $image->getPixel(9, 4);
        $this->assertEquals($expected_at_9_4, $color_at_9_4);

        // Cyan
        $expected_at_9_9 = new Color(0, 255, 255, 0);
        $color_at_9_9 = $image->getPixel(9, 9);
        $this->assertEquals($expected_at_9_9, $color_at_9_9);

        // Blue
        $expected_at_4_9 = new Color(0, 0, 255, 0);
        $color_at_4_9 = $image->getPixel(4, 9);
        $this->assertEquals($expected_at_4_9, $color_at_4_9);

        // Magenta
        $expected_at_0_9 = new Color(255, 0, 255, 0);
        $color_at_0_9 = $image->getPixel(0, 9);
        $this->assertEquals($expected_at_0_9, $color_at_0_9);

        // Grey
        $expected_at_0_4 = new Color(128, 128, 128, 0);
        $color_at_0_4 = $image->getPixel(0, 4);
        $this->assertEquals($expected_at_0_4, $color_at_0_4);

        // Black
        $expected_at_1_1 = new Color(0, 0, 0, 0);
        $color_at_1_1 = $image->getPixel(1, 1);
        $this->assertEquals($expected_at_1_1, $color_at_1_1);

        // Transparent 50%
        $expected_at_2_2 = new Color(255, 255, 255, 63);
        $color_at_2_2 = $image->getPixel(2, 2);
        $this->assertEquals($expected_at_2_2, $color_at_2_2);

        // Transparent 100%
        $expected_at_3_3 = new Color(255, 255, 255, 127);
        $color_at_3_3 = $image->getPixel(3, 3);
        $this->assertEquals($expected_at_3_3, $color_at_3_3);
    }

    public function testSetPixel()
    {
        $image = new Image(20, 20);

        $x = 10;
        $y = 10;
        $color = new Color(255, 0, 0, 0);

        $image->setPixel($x, $y, $color);

        $this->assertEquals($color, $image->getPixel($x, $y));

    }
}
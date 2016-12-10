<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\ImageManipulator;

use Devtronic\ImageManipulator\Color;
use Devtronic\ImageManipulator\Enum\FlipMode;
use Devtronic\ImageManipulator\FileLoader\BasicFileLoader;
use Devtronic\ImageManipulator\Image;
use Devtronic\ImageManipulator\Pen;
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

    public function testFill()
    {
        $image = new Image(30, 30);

        $fillColor = new Color(255, 0, 0, 64);

        $image->fill($fillColor);

        $this->assertEquals($fillColor, $image->getPixel(15, 15));
    }

    public function testResize()
    {
        $imageFile = __DIR__ . '/resources/test.png';

        $image = Image::createFromFile($imageFile, new BasicFileLoader());

        $newWidth = 100;
        $newHeight = 100;
        $resample = true;

        $image->resize($newWidth, $newHeight, $resample);

        $this->assertSame($newWidth, $image->getWidth());
        $this->assertSame($newHeight, $image->getHeight());
    }

    public function testFlip()
    {
        $imageFile = __DIR__ . '/resources/test.png';

        $image = Image::createFromFile($imageFile, new BasicFileLoader());

        $image->flip(FlipMode::FLIP_HORIZONTAL);

        $expected_0_0 = new Color(255, 255, 0, 0);

        $this->assertEquals($expected_0_0, $image->getPixel(0, 0));
    }

    public function testDrawLine()
    {
        $image = new Image(100, 100);

        $penColor = new Color(255, 0, 0, 0);
        $pen = new Pen($penColor);

        $image->drawLine($pen, 0, 0, 100, 100);

        $this->assertEquals($penColor, $image->getPixel(0, 0));
        $this->assertEquals($penColor, $image->getPixel(50, 50));
        $this->assertEquals($penColor, $image->getPixel(99, 99));
    }

    public function testDrawRectangle()
    {
        $image = new Image(100, 100);

        $transparent = new Color(0, 0, 0, 127);
        $penColor = new Color(0, 0, 0, 0);
        $pen = new Pen($penColor);

        $image->drawRectangle($pen, 10, 10, 80, 80);

        $expected_9_9 = $transparent;
        $expected_90_9 = $transparent;
        $expected_9_90 = $transparent;
        $expected_90_90 = $transparent;

        $expected_10_10 = $penColor;
        $expected_10_89 = $penColor;
        $expected_89_10 = $penColor;
        $expected_89_89 = $penColor;

        $this->assertEquals($expected_9_9, $image->getPixel(9, 9));
        $this->assertEquals($expected_90_9, $image->getPixel(90, 9));
        $this->assertEquals($expected_9_90, $image->getPixel(9, 90));
        $this->assertEquals($expected_90_90, $image->getPixel(90, 90));

        $this->assertEquals($expected_10_10, $image->getPixel(10, 10));
        $this->assertEquals($expected_10_89, $image->getPixel(10, 89));
        $this->assertEquals($expected_89_10, $image->getPixel(89, 10));
        $this->assertEquals($expected_89_89, $image->getPixel(89, 89));
    }

}
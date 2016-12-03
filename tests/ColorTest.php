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
use Devtronic\ImageManipulator\Image;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testConstructor()
    {
        $red = 255;
        $green = 255;
        $blue = 255;
        $alpha = 0;
        $color = new Color($red, $green, $blue, $alpha);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
        $this->assertEquals($alpha, $color->getAlpha());

        $red = 126;
        $green = 33;
        $blue = 44;
        $alpha = 63;
        $color = new Color($red, $green, $blue, $alpha);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
        $this->assertEquals($alpha, $color->getAlpha());
    }

    public function testCreateFromIndex()
    {
        $image = new Image(1, 1);

        $index = 1065230691;
        $expected = new Color(126, 33, 99, 63);
        $color = Color::createFromIndex($image, $index);

        $this->assertEquals($expected, $color);
    }

    public function testConvertToIndex()
    {
        $image = new Image(1, 1);

        $expected = 1065230691;
        $color = new Color(126, 33, 99, 63);

        $this->assertEquals($expected, $color->toIndex($image));
    }
}
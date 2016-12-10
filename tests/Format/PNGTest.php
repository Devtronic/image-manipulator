<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\ImageManipulator\Format;

use Devtronic\ImageManipulator\Format\PNG;
use Devtronic\ImageManipulator\IFileFormat;
use Devtronic\ImageManipulator\Image;
use PHPUnit\Framework\TestCase;

class PNGTest extends TestCase
{
    public function testConstruct()
    {
        $format = new PNG();

        $this->assertTrue($format instanceof IFileFormat);
    }

    public function testSaving()
    {
        $resDir = __DIR__ . '/../resources';
        $image = Image::createFromFile($resDir . '/test.png');

        $outputFile = $resDir . '/png.format.png';
        $image->save($outputFile, new PNG());

        $this->assertFileExists($outputFile);

        $image2 = Image::createFromFile($outputFile);

        $this->assertEquals($image->getWidth(), $image2->getWidth());
        $this->assertEquals($image->getHeight(), $image2->getHeight());
        $this->assertEquals($image->getPixel(1, 1), $image2->getPixel(1, 1));

        unlink($outputFile);
        $this->assertFileNotExists($outputFile);
    }
}
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

use Devtronic\ImageManipulator\Format\BWText;
use Devtronic\ImageManipulator\IFileFormat;
use Devtronic\ImageManipulator\Image;
use PHPUnit\Framework\TestCase;

class BWTextTest extends TestCase
{
    public function testConstruct()
    {
        $format = new BWText();

        $this->assertTrue($format instanceof IFileFormat);
    }


    public function testSaving()
    {
        $resDir = __DIR__ . '/../resources';
        $image = Image::createFromFile($resDir . '/test.png');

        $outputFile = $resDir . '/bwtext.format.txt';
        $image->save($outputFile, new BWText(0.3, 'x', ' '));

        $lines = file($outputFile);

        $this->assertSame(' ', $lines[0][0]);
        $this->assertSame('x', $lines[1][1]);
        $this->assertSame(' ', $lines[0][1]);
        $this->assertSame(' ', $lines[1][0]);

        $this->assertFileExists($outputFile);

        unlink($outputFile);
        $this->assertFileNotExists($outputFile);
    }
}
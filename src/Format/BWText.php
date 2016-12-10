<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator\Format;

use Devtronic\ImageManipulator\IFileFormat;
use Devtronic\ImageManipulator\Image;

/**
 * PNG Output Format
 *
 * @package Devtronic\ImageManipulator
 */
class BWText implements IFileFormat
{
    /** @var int */
    private $threshold;

    /** @var string */
    private $blackChar;

    /** @var string */
    private $whiteChar;

    public function __construct($threshold = 0.6, $blackChar = 'x', $whiteChar = ' ')
    {
        $this->threshold = $threshold;
        $this->blackChar = $blackChar;
        $this->whiteChar = $whiteChar;
    }

    /**
     * Encodes the given image to specific format
     *
     * @param Image $image
     * @return string The raw data which will be written into the file
     */
    public function encode(Image $image): string
    {
        $data = '';
        for ($x = 0; $x < $image->getWidth(); $x++) {
            for ($y = 0; $y < $image->getHeight(); $y++) {
                $color = $image->getPixel($x, $y);
                $lightning = ($color->getRed() + $color->getGreen() + $color->getBlue()) / 3 / 255;
                $data .= ($lightning >= $this->threshold ? $this->whiteChar : $this->blackChar);
            }
            $data .= PHP_EOL;
        }

        return $data;
    }

}
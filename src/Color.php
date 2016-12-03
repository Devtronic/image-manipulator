<?php declare(strict_types = 1);
/*
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator;

/**
 * Color Object
 *
 * @package Devtronic\ImageManipulator
 */
class Color
{
    /** @var int */
    private $red;

    /** @var int */
    private $green;

    /** @var int */
    private $blue;

    /** @var int */
    private $alpha;

    /**
     * Color constructor.
     *
     * @param int $red Red (0-255)
     * @param int $green Green (0-255)
     * @param int $blue Blue (0-255)
     * @param int $alpha Alpha (0-127)
     */
    public function __construct(int $red = 0, int $green = 0, int $blue = 0, int $alpha = 0)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
    }

    /**
     * Create Color object from color index
     *
     * @param Image $image The Image
     * @param int $index The color index
     * @return Color The Color object
     */
    public static function createFromIndex(Image &$image, int $index): Color
    {
        $colors = imagecolorsforindex($image->getImageResource(), $index);

        return new Color($colors['red'], $colors['green'], $colors['blue'], $colors['alpha']);
    }

    /**
     * Converts the color to index
     *
     * @param Image $image The image
     * @return int The index
     */
    public function toIndex(Image &$image): int
    {
        return imagecolorallocatealpha($image->getImageResource(), $this->red, $this->green, $this->blue, $this->alpha);
    }

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * @param int $red
     * @return Color
     */
    public function setRed(int $red): Color
    {
        $this->red = $red;
        return $this;
    }

    /**
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * @param int $green
     * @return Color
     */
    public function setGreen(int $green): Color
    {
        $this->green = $green;
        return $this;
    }

    /**
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * @param int $blue
     * @return Color
     */
    public function setBlue(int $blue): Color
    {
        $this->blue = $blue;
        return $this;
    }

    /**
     * @return int
     */
    public function getAlpha(): int
    {
        return $this->alpha;
    }

    /**
     * @param int $alpha
     * @return Color
     */
    public function setAlpha(int $alpha): Color
    {
        $this->alpha = $alpha;
        return $this;
    }
}
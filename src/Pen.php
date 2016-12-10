<?php declare(strict_types = 1);
/**
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
class Pen
{
    /** @var Color */
    private $color;

    /** @var int */
    private $width;

    /**
     * Creates a new Pencil
     *
     * @param Color $color Pencil Color
     * @param int $width
     */
    public function __construct(Color $color, int $width = 1)
    {
        $this->color = $color;
        $this->width = $width;
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @param Color $color
     * @return Pen
     */
    public function setColor(Color $color): Pen
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return Pen
     */
    public function setWidth(int $width): Pen
    {
        $this->width = $width;
        return $this;
    }


}
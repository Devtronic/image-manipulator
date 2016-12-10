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


interface IFileFormat
{
    /**
     * Encodes the given image to specific format
     *
     * @param Image $image
     * @return string The raw data which will be written into the file
     */
    public function encode(Image $image): string;
}
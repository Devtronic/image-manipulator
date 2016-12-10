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


interface IFileLoader
{
    /**
     * Loads the Image file
     * @param string $filename
     * @return resource The Image Resource
     */
    public function loadFile(string $filename);
}
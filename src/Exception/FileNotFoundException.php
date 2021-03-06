<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct($filename)
    {
        parent::__construct(sprintf('File %s not found', $filename), 0, null);
    }
}
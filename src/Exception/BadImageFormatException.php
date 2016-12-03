<?php declare(strict_types = 1);
/*
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator\Exception;

use Devtronic\ImageManipulator\IFileLoader;
use Exception;

class BadImageFormatException extends \Exception
{
    public function __construct(string $filename, IFileLoader $fileLoader)
    {
        parent::__construct(sprintf('FileLoader "%s" could not load file %s', get_class($fileLoader), $filename), 0,
            null);
    }
}
<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator\Enum;

abstract class FlipMode
{
    const FLIP_HORIZONTAL = IMG_FLIP_HORIZONTAL;
    const FLIP_VERTICAL = IMG_FLIP_VERTICAL;
    const FLIP_BOTH = IMG_FLIP_BOTH;
}
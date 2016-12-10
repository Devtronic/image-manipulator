<?php declare(strict_types = 1);
/**
 * This file is part of the Devtronic Image Manipulator package.
 *
 * (c) Julian Finkler <admin@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\ImageManipulator\FileLoader;

use Devtronic\ImageManipulator\IFileLoader;

/**
 * Simple FileLoader
 * Can load *.png, *.gif, *.jpg, *.jpeg, *.wbmp, *.webp, *.xbm, *.xpm files
 *
 * @package Devtronic\ImageManipulator\FileLoader
 */
class BasicFileLoader implements IFileLoader
{
    /**
     * Loads the Image file
     *
     * @param string $filename
     * @return resource The Image Resource
     */
    public function loadFile(string $filename)
    {
        $pathInfo = pathinfo($filename);
        $pathInfo['extension'] = strtolower($pathInfo['extension']);

        $methodCall = '';
        if ($pathInfo['extension'] === 'png') {
            $methodCall = 'imagecreatefrompng';
        } elseif ($pathInfo['extension'] === 'gif') {
            $methodCall = 'imagecreatefromgif';
        } elseif ($pathInfo['extension'] === 'jpg' || $pathInfo['extension'] === 'jpeg') {
            $methodCall = 'imagecreatefromjpeg';
        } elseif ($pathInfo['extension'] === 'wbmp') {
            $methodCall = 'imagecreatefromwbmp';
        } elseif ($pathInfo['extension'] === 'webp') {
            $methodCall = 'imagecreatefromwebp';
        } elseif ($pathInfo['extension'] === 'xbm') {
            $methodCall = 'imagecreatefromxbm';
        } elseif ($pathInfo['extension'] === 'xpm') {
            $methodCall = 'imagecreatefromxpm';
        }

        $resource = null;
        if ($methodCall != '') {
            $resource = $methodCall($filename);
        }

        return $resource;
    }
}
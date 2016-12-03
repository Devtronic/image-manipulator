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

use Devtronic\ImageManipulator\Exception\BadImageFormatException;
use Devtronic\ImageManipulator\Exception\FileNotFoundException;
use Devtronic\ImageManipulator\FileLoader\BasicFileLoader;

class Image
{
    /** @var \resource */
    private $imageResource;

    /**
     * Creates a new Image
     *
     * @param int $width Width of the Image
     * @param int $height Height of the Image
     */
    public function __construct(int $width, int $height)
    {
        $this->imageResource = imagecreatetruecolor($width, $height);
    }

    /**
     * Creates a new Image-object from given file
     *
     * @param string $filename Image filename
     * @param IFileLoader|null $fileLoader FileLoader
     * @return Image Instance of Image
     *
     * @throws BadImageFormatException
     * @throws FileNotFoundException
     */
    public static function createFromFile(string $filename, IFileLoader $fileLoader = null): Image
    {
        if (!is_file($filename)) {
            throw new FileNotFoundException($filename);
        }
        if ($fileLoader === null) {
            $fileLoader = new BasicFileLoader();
        }

        $resource = $fileLoader->loadFile($filename);

        if (gettype($resource) !== 'resource') {
            throw new BadImageFormatException($filename, $fileLoader);
        }

        return Image::createFromResource($resource);
    }

    /**
     * Creates a new Image-object from given image resource
     *
     * @param resource $resource The image resource
     * @return Image The Image object
     */
    public static function createFromResource($resource): Image
    {
        $image = new Image(imagesx($resource), imagesy($resource));
        $image->setImageResource($resource);
        return $image;
    }

    /**
     * Returns the Color for specific location
     *
     * @param int $x x-coordinate
     * @param int $y y-coordinate
     * @return Color The color
     */
    public function getPixel(int $x, int $y): Color
    {
        $index = imagecolorat($this->imageResource, $x, $y);
        return Color::createFromIndex($this, $index);
    }

    /**
     * Sets the color for given location
     *
     * @param int $x x-coordinate
     * @param int $y y-coordinate
     * @param Color $color The color
     * @return bool true on success or false on failure.
     */
    public function setPixel(int $x, int $y, Color $color): bool
    {
        return imagesetpixel($this->imageResource, $x, $y, $color->toIndex($this));
    }

    /**
     * Get image width
     *
     * @return int
     */
    public function getWidth(): int
    {
        if (gettype($this->imageResource) !== 'resource') {
            throw new \BadMethodCallException();
        }
        return imagesx($this->imageResource);
    }

    /**
     * Get image height
     *
     * @return int
     */
    public function getHeight(): int
    {
        if (gettype($this->imageResource) !== 'resource') {
            throw new \BadMethodCallException();
        }
        return imagesy($this->imageResource);
    }

    /**
     * @return resource
     */
    public function getImageResource()
    {
        return $this->imageResource;
    }

    /**
     * @param resource $imageResource
     * @return Image
     */
    public function setImageResource($imageResource): Image
    {
        $this->imageResource = $imageResource;
        return $this;
    }
}
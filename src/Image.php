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

use Devtronic\ImageManipulator\Enum\FlipMode;
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
        imagesavealpha($this->imageResource, true);
        $this->fill(new Color(0, 0, 0, 127));
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
     * Saves the Image to File
     *
     * @param string $filename The output file
     * @param IFileFormat $format The file format
     * @return bool
     * @throws \Exception
     */
    public function save(string $filename, IFileFormat $format): bool
    {
        $handle = fopen($filename, 'w+');
        if ($handle === false) {
            throw new \Exception(sprintf('Could not open %s for writing', $filename));
        }

        $data = $format->encode($this);
        fwrite($handle, $data);
        fclose($handle);

        return true;
    }

    /**
     * Fills the image with given color
     *
     * @param Color $color The color to fill
     * @return bool true on success or false on failure.
     */
    public function fill(Color $color): bool
    {
        return imagefill($this->imageResource, 0, 0, $color->toIndex($this));
    }

    /**
     * Resize the Image
     *
     * @param int $newWidth The resized width
     * @param int $newHeight The resized height
     * @param bool $resample Use resampling
     */
    public function resize(int $newWidth, int $newHeight, bool $resample = true)
    {
        if ($newWidth <= 0 || $newHeight <= 0) {
            throw new \InvalidArgumentException("\$newWidth and \$newHeight must be greater that 0");
        }

        $resized = new Image($newWidth, $newHeight);
        list($width, $height) = array($this->getWidth(), $this->getHeight());
        if ($resample === true) {
            imagecopyresampled($resized->imageResource, $this->imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $width,
                $height);
        } else {
            imagecopyresized($resized->imageResource, $this->imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $width,
                $height);
        }

        $this->imageResource = $resized->imageResource;
    }

    /**
     * Flips the image with given mode
     *
     * @param int $flipMode FlipMode
     * @return bool true on success or false on failure.
     * @see FlipMode
     */
    public function flip(int $flipMode = FlipMode::FLIP_HORIZONTAL): bool
    {
        return imageflip($this->imageResource, $flipMode);
    }

    /**
     * Draws a line between two points
     *
     * @param Pen $pen Pen
     * @param int $srcX Source X
     * @param int $srcY Source Y
     * @param int $trgX Target X
     * @param int $trgY Target Y
     * @return bool true on success or false on failure.
     */
    public function drawLine(Pen $pen, int $srcX, int $srcY, int $trgX, int $trgY): bool
    {
        imagesetthickness($this->imageResource, $pen->getWidth());
        $color = $pen->getColor()->toIndex($this);
        return imageline($this->imageResource, $srcX, $srcY, $trgX, $trgY, $color);
    }

    /**
     * Draw a rectangle
     *
     * @param Pen $pen Pen
     * @param int $x X
     * @param int $y Y
     * @param int $width Rectangle-Width
     * @param int $height Rectangle-Height
     * @return bool
     */
    public function drawRectangle(Pen $pen, int $x, int $y, int $width, int $height): bool
    {
        imagesetthickness($this->imageResource, $pen->getWidth());
        $color = $pen->getColor()->toIndex($this);
        return imagerectangle($this->imageResource, $x, $y, $width + $x - 1, $height + $y - 1, $color);
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
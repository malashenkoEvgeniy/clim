<?php

namespace App\Components\Image;

use App\Exceptions\WrongParametersException;
use Illuminate\Support\Collection;

class ImagesGroup
{
    
    /**
     * Images presets list
     *
     * @var Collection|Image[]
     */
    public $sizes;
    
    /**
     * Main folder for current type of images
     *
     * @var string
     */
    public $folder;
    
    /**
     * ImagesGroup constructor.
     *
     * @param  string $folder
     * @param  bool $original
     * @param  array|Image[] $sizes
     * @throws WrongParametersException
     */
    public function __construct(string $folder, array $sizes = [], bool $original = true)
    {
        $this->folder = $folder;
        $this->sizes = new Collection();
        foreach ($sizes as $size) {
            $this->add($size);
        }
        if ($original === true && $this->sizes->has('original') === false) {
            $this->addOriginal();
        }
    }
    
    /**
     * Add size to the list
     *
     * @param  array|Image $size
     * @return $this
     * @throws WrongParametersException
     */
    public function add($size)
    {
        if ($size instanceof Image) {
            $this->sizes->put($size->getFolder(), $size);
        } elseif (is_array($size)) {
            $image = (new Image)->presets($size);
            $this->sizes->put($image->getFolder(), $image);
        } else {
            throw new WrongParametersException('Wrong structure of the `size` parameter!');
        }
        
        return $this;
    }
    
    /**
     * Add image folder
     *
     * @param  string $folder
     * @param  array $presets
     * @return Image
     * @throws WrongParametersException
     */
    public function addTo(string $folder, array $presets = [])
    {
        $image = new Image;
        $image->presets($presets);
        $image->setFolder($folder);
        $this->add($image);
        
        return $image;
    }
    
    /**
     * Add original image to the list
     *
     * @return Image
     * @throws WrongParametersException
     */
    public function addOriginal()
    {
        $image = new Image;
        $image->setFolder('original');
        $this->add($image);
        
        return $image;
    }
    
    /**
     * Get path inside storage folder to new image
     *
     * @param  string $filename
     * @return string
     */
    public function getPathToImage(string $filename)
    {
        return "{$this->folder}/{$filename}";
    }
    
    /**
     * Full path to new image location
     *
     * @param  string $filename
     * @return string
     */
    public function getFullPathToImage(string $filename)
    {
        return config('filesystems.disks.' . config('filesystems.default') . '.root') . '/' . $this->getPathToImage($filename);
    }
    
    /**
     * Delete all images for this group
     *
     * @param string $filename
     */
    public function deleteImages(string $filename)
    {
        if (!$filename) {
            return;
        }
        Image::delete($this->getPathToImage($filename));
    }
    
    /**
     * Get image settings by type
     *
     * @param  string $folder
     * @return null|Image
     */
    public function getImage(string $folder)
    {
        if ($this->sizes->has($folder)) {
            return $this->sizes->get($folder);
        }
    }
    
    /**
     * Elements to show
     *
     * @return Collection|Image[]
     */
    public function imagesThatCanBeCropped()
    {
        $elements = new Collection();
        $this->sizes->each(
            function (Image $image) use (&$elements) {
                if ($image->getFolder() === 'original') {
                    return;
                }
                if ($image->getCrop() !== true || !$image->getWidth() || !$image->getHeight()) {
                    return;
                }
                $elements->push($image);
            }
        );
        return $elements;
    }
    
}

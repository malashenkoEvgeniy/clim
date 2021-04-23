<?php

namespace CustomForm;

use App\Exceptions\WrongParametersException;
use App\Helpers\Quantity;
use URL;
use App\Core\Modules\Images\Models\Image as ImageModel;

/**
 * Class Input
 * Simple input element of the form
 *
 * @package CustomForm
 */
class Image extends Element
{
    
    protected $template = 'admin.form.image';
    
    /**
     * Options by default
     *
     * @var array
     */
    protected $options = ['accept' => '.jpeg, .png, .jpg'];
    
    /**
     * Delete image URL
     *
     * @var string
     */
    protected $deleteUrl;
    
    /**
     * Image preview
     *
     * @var string
     */
    protected $preview;
    
    /**
     * Big image link
     *
     * @var string
     */
    protected $image;
    
    /**
     * Image constructor.
     *
     * @param string $name
     * @param null|ImageModel $object
     * @throws WrongParametersException
     */
    public function __construct(string $name, ?ImageModel $object = null)
    {
        parent::__construct($name, $object);
        
        $this->setHelp(__('messages.image-max-size', [
            'size' => Quantity::getMbFromKb(config('image.max-size')),
        ]));
    }
    
    /**
     * Includes some formats
     *
     * @param array $formats
     * @return self
     */
    public function includeFormats(...$formats): self
    {
        array_unshift($formats, array_get($this->options, 'accept', ''));
        $this->options['accept'] = implode(', ', $formats);
        
        return $this;
    }
    
    /**
     * Set preview image
     *
     * @param  string|null $link
     * @return $this
     */
    public function setPreview($link)
    {
        if ($link) {
            $this->preview = $link;
        }
        
        return $this;
    }
    
    /**
     * Get preview
     *
     * @return string
     */
    public function getPreview()
    {
        return $this->preview ?? (($this->object && $this->object->exists) ? ($this->object->link('small') ?: $this->object->link('original')) : null);
    }
    
    /**
     * Set big image
     *
     * @param  string|null $link
     * @return $this
     */
    public function setImage($link)
    {
        if ($link) {
            $this->image = $link;
        }
        
        return $this;
    }
    
    /**
     * Get big image link
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image ?? (($this->object && $this->object->exists) ? $this->object->link('original') : null);
    }
    
    /**
     * Get delete image link
     *
     * @return string
     * @throws WrongParametersException
     */
    public function getDeleteUrl(): string
    {
        if ($this->deleteUrl) {
            return $this->deleteUrl;
        }
        if (!$this->object || !$this->object->id) {
            throw new WrongParametersException('Wrong object!');
        }
        return route('admin.images.destroy', [
            'image' => $this->object->id,
        ]);
    }
    
    /**
     * @param string $deleteUrl
     * @return Image
     */
    public function setDeleteUrl(string $deleteUrl): self
    {
        $this->deleteUrl = $deleteUrl;
        
        return $this;
    }
    
    /**
     * This method says if we need to show `crop` button
     *
     * @return bool
     */
    public function needToShowCropButton()
    {
        return !!$this->object &&
            method_exists($this->object, 'configurations') &&
            $this->object->configurations()->imagesThatCanBeCropped()->count() > 0;
    }
    
    /**
     * Generates link to crop model
     *
     * @return string
     */
    public function getCropLink()
    {
        return route('admin.crop.index', [
            'crop' => $this->object->id,
            'back' => URL::current(),
        ]);
    }
    
}

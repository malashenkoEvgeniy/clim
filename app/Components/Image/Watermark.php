<?php

namespace App\Components\Image;

/**
 * Class Watermark
 *
 * @package App\Components\Image
 */
class Watermark
{
    
    // Available watermark positions
    const POSITION_TOP_LEFT = 'top-left';
    const POSITION_TOP = 'top';
    const POSITION_TOP_RIGHT = 'top-right';
    const POSITION_LEFT = 'left';
    const POSITION_CENTER = 'center';
    const POSITION_RIGHT = 'right';
    const POSITION_BOTTOM_LEFT = 'bottom-left';
    const POSITION_BOTTOM = 'bottom';
    const POSITION_BOTTOM_RIGHT = 'bottom-right';
    const FILL = 'fill';
    
    /**
     * Do we need to overlay watermark
     *
     * @var bool
     */
    private $overlay;
    
    /**
     * Path to the watermark over storage/* folder
     *
     * @var string
     */
    private $path;
    
    /**
     * Position of the watermark
     *
     * @var string
     */
    private $position;
    
    /**
     * Opacity of the watermark
     * Can be between 1 and 100
     *
     * @var int
     */
    private $opacity;
    
    /**
     * Width of the watermark positioned by image size
     *
     * @var int
     */
    private $widthPercent;
    
    /**
     * Offset over X
     *
     * @var int
     */
    private $x;
    
    /**
     * Offset over Y
     *
     * @var int
     */
    private $y;
    
    /**
     * Watermark constructor.
     *
     * @param null|string $path
     */
    public function __construct($path = null)
    {
        $this->overlay = (bool)config('db.watermark.overlay');
        $this->position = config('db.watermark.position', static::POSITION_BOTTOM);
        $this->opacity = config('db.watermark.opacity', 100);
        $this->widthPercent = config('db.watermark.width-percent', 50);
        $this->x = config('image.watermark.x', 15);
        $this->y = config('image.watermark.y', 0);
        if ($path !== null) {
            $this->path = $path;
        } else {
            $this->path = storage_path('app/public/' . config('image.watermark.name'));
        }
    }
    
    /**
     * Does watermark exist?
     *
     * @return bool
     */
    public function exists()
    {
        return is_file($this->path);
    }
    
    /**
     * Overlay?
     *
     * @return bool
     */
    public function overlay(): bool
    {
        return $this->overlay && $this->exists();
    }
    
    /**
     * Path to file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Opacity
     *
     * @return int
     */
    public function getOpacity()
    {
        return (int)$this->opacity;
    }
    
    /**
     * Position
     *
     * @return string
     */
    public function getPosition()
    {
        return (string)$this->position;
    }
    
    /**
     * Do we need to fill image by watermark copies
     *
     * @return bool
     */
    public function fill(): bool
    {
        return (string)$this->position === static::FILL;
    }
    
    /**
     * Width percent from image size
     *
     * @return int
     */
    public function getWidthPercent()
    {
        return (int)$this->widthPercent;
    }
    
    /**
     * X offset
     *
     * @return int
     */
    public function getX()
    {
        return (int)$this->x;
    }
    
    /**
     * Y offset
     *
     * @return int
     */
    public function getY()
    {
        return (int)$this->y;
    }
    
}

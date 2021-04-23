<?php

namespace App\Core\Modules\Notifications\Types;

/**
 * Class NotificationType
 *
 * @package App\Core\Modules\Notifications
 */
class NotificationType
{
    
    const COLOR_RED = 'text-red';
    const COLOR_YELLOW = 'text-yellow';
    const COLOR_AQUA = 'text-aqua';
    const COLOR_BLUE = 'text-blue';
    const COLOR_BLACK = 'text-black';
    const COLOR_LIGHT_BLUE = 'text-light-blue';
    const COLOR_GREEN = 'text-green';
    const COLOR_GRAY = 'text-gray';
    const COLOR_NAVY = 'text-navy';
    const COLOR_TEAL = 'text-teal';
    const COLOR_OLIVE = 'text-olive';
    const COLOR_LIME = 'text-lime';
    const COLOR_ORANGE = 'text-orange';
    const COLOR_FUCHSIA = 'text-fuchsia';
    const COLOR_PURPLE = 'text-purple';
    const COLOR_MAROON = 'text-maroon';
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string|null
     */
    protected $icon;
    
    /**
     * @var string|null
     */
    protected $color;
    
    /**
     * @return mixed
     */
    public function getColor(): string
    {
        return $this->color ?? static::COLOR_BLACK;
    }
    
    /**
     * @return mixed
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }
    
    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }
    
    /**
     * @param string|null $icon
     */
    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }
    
    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    
}
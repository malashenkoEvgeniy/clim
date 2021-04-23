<?php

namespace CustomForm\Builder;


/**
 * Class ViewSet
 * Field set of form elements
 *
 * @package CustomForm\Builder
 */
class ViewSet
{
    /**
     * Number from 1 to 12
     * By default - 12
     *
     * @var int
     */
    private $width;

    /**
     * Path include file
     *
     * @var null|string
     */
    private $path;

    /**
     * Params in view
     *
     * @var array
     */
    private $params;
    
    /**
     * Do we need to use boxes
     *
     * @var bool
     */
    private $boxed = true;

    /**
     * FieldSet constructor.
     *
     * @param int $width
     * @param string $path
     * @param array $params
     */
    public function __construct(string $path, array $params = [], int $width = 12)
    {
        // Set width
        $this->width = $width < 0 || $width > 12 ? 12 : $width;
        // Set view
        $this->path = $path;
        // Set params
        $this->params = $params;
    }
    
    /**
     * @param bool $boxed
     * @return ViewSet
     */
    public function boxed(bool $boxed): ViewSet
    {
        $this->boxed = $boxed;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isBoxed(): bool
    {
        return $this->boxed;
    }

    /**
     * Returns width
     * This is a number from 1 to 12
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Returns path file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}

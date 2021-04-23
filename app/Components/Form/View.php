<?php

namespace CustomForm;

/**
 * Class View
 *
 * @package CustomForm
 */
class View extends Element
{
    /**
     * Content to view
     *
     * @var string|null
     */
    private $content;
    
    /**
     * View constructor.
     * @param string $name
     * @param null $object
     * @throws \App\Exceptions\WrongParametersException
     */
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
    }
    
    /**
     * Set $content property
     *
     * @param string $content|null
     * @return View
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        
        return $this;
    }
    
    /**
     * Get $content property
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * Render $content property
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null|string
     */
    public function render()
    {
        return $this->content ?? '';
    }
}

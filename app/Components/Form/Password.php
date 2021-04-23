<?php

namespace CustomForm;

/**
 * Class Input
 * Simple input element of the form
 *
 * @package CustomForm
 */
class Password extends Input
{
    
    protected $template = 'admin.form.input';
    
    /**
     * Password constructor.
     *
     * @param  string $name
     * @param  null $object
     * @throws \App\Exceptions\WrongParametersException
     */
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->setType('password');
    }
    
    /**
     * Overload render method
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        // Password always invisible
        $this->setValue('');
        // Render component
        return parent::render();
    }
    
}

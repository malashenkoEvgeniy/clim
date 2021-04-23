<?php

namespace CustomForm;

/**
 * Class Input
 * Simple input element of the form
 *
 * @package CustomForm
 */
class TinyMce extends TextArea
{
    
    protected $template = 'admin.form.textarea';
    
    protected $options = ['style' => 'height: 300px;'];
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'tinymceEditor';
    }
}

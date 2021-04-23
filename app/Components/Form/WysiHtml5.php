<?php

namespace CustomForm;

/**
 * Class WysiHtml5
 * Simple input element of the form
 *
 * @package CustomForm
 */
class WysiHtml5 extends TextArea
{
    
    protected $template = 'admin.form.textarea';
    
    protected $options = ['style' => 'height: 150px;'];
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'wysihtml5';
    }
}

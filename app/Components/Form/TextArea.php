<?php

namespace CustomForm;

/**
 * Class Input
 * Simple input element of the form
 *
 * @package CustomForm
 */
class TextArea extends Element
{
    
    protected $template = 'admin.form.textarea';
    
    protected $options = ['style' => 'resize: none;', 'rows' => 5];
    
}

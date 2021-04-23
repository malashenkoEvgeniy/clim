<?php

namespace CustomForm;

/**
 * Class SimpleElement
 *
 * @package CustomForm
 */
class SimpleElement extends Element
{
    
    protected $template = 'admin.form.simple-element';
    
    /**
     * @param null|string $name
     * @param null $object
     * @return Element
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function create(?string $name = null, $object = null)
    {
        return parent::create($name ?? random_int(10000, 99999), $object);
    }
    
}

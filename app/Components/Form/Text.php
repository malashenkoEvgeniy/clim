<?php

namespace CustomForm;

/**
 * Class Input
 * Simple input element of the form
 *
 * @package CustomForm
 */
class Text extends Element
{
    
    protected $template = 'admin.form.text';
    
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
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->setLabel(false);
    }
    
}

<?php

namespace CustomForm;

/**
 * Select
 *
 * @package CustomForm
 */
class Select extends SimpleSelect
{
    
    /**
     * Select constructor
     *
     * @param  string $name
     * @param  null $object
     * @throws \App\Exceptions\WrongParametersException
     */
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        $this->classes[] = 'select2';
    }
    
}

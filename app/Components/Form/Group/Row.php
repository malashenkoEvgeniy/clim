<?php

namespace CustomForm\Group;

use Illuminate\Support\Str;

/**
 * Class Row
 * @package CustomForm\Group
 */
class Row extends Group
{
    
    protected $template = 'admin.form.group-simple';
    
    /**
     * @param string|null $name
     * @param null $object
     * @return Group|Row
     * @throws \App\Exceptions\WrongParametersException
     */
    static function create(?string $name = null, $object = null)
    {
        $name = $name ?? Str::random(12);
        $row = new static($name, $object);
        $row->addClassesToDiv('row');
        $row->setLabel(false);
        return $row;
    }
}

<?php

namespace CustomForm\Macro;

use CustomForm\Group\Group;
use CustomForm\Group\Radio;

/**
 * Class Toggle
 *
 * @package CustomForm\Macro
 */
class Toggle extends Group
{
    public function __construct($name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->setDefaultValue(1);
    }
    
    /**
     * Render toggle block
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {
        $this->add(
            Radio::create($this->getName(), $this->object)->setLabel(__('global.yes'))->setValue(1),
            Radio::create($this->getName(), $this->object)->setLabel(__('global.no'))->setValue(0)
        );
        return parent::render();
    }
    
}

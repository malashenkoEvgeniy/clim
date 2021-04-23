<?php

namespace App\Traits;

use CustomForm\Element;

/**
 * Trait Commentable
 *
 * @package App\Traits
 */
trait Commentable
{
    
    /**
     * @param int|null $commentableId
     * @return Element|null
     */
    abstract static function formElementForComments(?int $commentableId = null): ?Element;
    
    /**
     * @param int|null $commentableId
     * @return string|null
     */
    abstract static function getElementForList(?int $commentableId = null): ?string;
    
}

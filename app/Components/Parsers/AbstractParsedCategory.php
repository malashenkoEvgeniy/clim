<?php

namespace App\Components\Parsers;

/**
 * Class AbstractParser
 * @property-read string|null $remoteCategoryId
 * @property-read string|null $categoryName
 * @property-read string|null $categoryId
 * @property-read string|null $remoteParentId
 * @property-read string|null $parentId
 * @package App\Components\Parsers
 */
abstract class AbstractParsedCategory extends AbstractItem
{
    /**
     * Parsing...
     */
    abstract public function parse(): void;
}

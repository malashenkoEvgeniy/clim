<?php

namespace App\Components\Parsers\PromUa;

use App\Components\Parsers\AbstractParsedCategory;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;

/**
 * Class Category
 *
 * @package App\Components\Parsers\PromUa
 */
class ParsedCategory extends AbstractParsedCategory
{
    
    /**
     * @var array
     */
    private $synonyms = [
        'Номер_группы' => 'remoteCategoryId',
        'Название_группы' => 'categoryName',
        'Идентификатор_группы' => 'categoryId',
        'Номер_родителя' => 'remoteParentId',
        'Идентификатор_родителя' => 'parentId',
    ];
    
    public static $requiredColumns = [
        'Номер_группы', 'Название_группы',
    ];
    
    /**
     * @var RowCellIterator
     */
    protected $cellIterator;
    
    /**
     * @var array
     */
    protected $columns;
    
    /**
     * @param RowCellIterator $cellIterator
     * @return ParsedCategory
     */
    public function setCellIterator(RowCellIterator $cellIterator): self
    {
        $this->cellIterator = $cellIterator;
        
        return $this;
    }
    
    /**
     * @param array $columns
     * @return ParsedCategory
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        
        return $this;
    }
    
    /**
     * Parsing...
     */
    public function parse(): void
    {
        foreach ($this->cellIterator as $cell) {
            $this->setAttribute($this->columns[$cell->getColumn()], $cell->getValue());
        }
    }
    
    /**
     * @param string $promUaPropertyName
     * @param mixed $value
     */
    public function setAttribute(string $promUaPropertyName, $value): void
    {
        if (isset($this->synonyms[$promUaPropertyName])) {
            $this->{$this->synonyms[$promUaPropertyName]} = $value;
        }
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setRemoteCategoryIdAttribute($categoryId)
    {
        $this->attributes['remoteCategoryId'] = (int)$categoryId ?: null;
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setCategoryIdAttribute($categoryId)
    {
        $this->attributes['categoryId'] = (int)$categoryId ?: null;
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setRemoteParentIdAttribute($categoryId)
    {
        $this->attributes['remoteParentId'] = (int)$categoryId ?: null;
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setParentIdAttribute($categoryId)
    {
        $this->attributes['parentId'] = (int)$categoryId ?: null;
    }
    
}

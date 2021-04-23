<?php

namespace App\Rules;

use App\Exceptions\WrongParametersException;
use DB, Schema;
use Illuminate\Contracts\Validation\Rule;

class MultilangSlug implements Rule
{
    /**
     * The ID that should be ignored.
     *
     * @var mixed
     */
    protected $ignoredRowId;
    
    protected $table;
    
    protected $column;
    
    protected $language;
    
    /**
     * Slug constructor.
     *
     * @param  string $table
     * @param  string $language
     * @param  int|null $ignoredRowId
     * @param  string $column
     * @throws WrongParametersException
     */
    public function __construct(string $table, string $language = null, int $ignoredRowId = null, string $column = 'slug')
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoredRowId = $ignoredRowId;
        $this->language = $language;
        
        if (!$table || !Schema::hasTable($table)) {
            throw new WrongParametersException("`$table` does not exist in the database!");
        }
        if (!$language || !config('languages.' . $language)) {
            $this->language = null;
        }
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->language) {
            return true;
        }
        $query = DB::table($this->table)
            ->where('language', '=', $this->language)
            ->where($this->column, '=', $value);
        if ($this->ignoredRowId) {
            $query->where('row_id', '!=', $this->ignoredRowId);
        }
        return $query->count() === 0;
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.slug');
    }
    
    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString()
    {
        return rtrim(
            sprintf(
                'unique:%s,%s,%s',
                $this->table,
                $this->ignoredRowId ? '"' . $this->ignoredRowId . '"' : 'NULL',
                $this->column
            ), ','
        );
    }
    
    public function getTable()
    {
        return $this->table;
    }
    
    public function setLanguage(string $language)
    {
        $this->language = $language;
        
        return $this;
    }
}

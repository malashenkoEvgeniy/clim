<?php

namespace App\Modules\Features\Rules;

use App\Modules\Features\Models\FeatureValueTranslates;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class FeatureValueMultilangSlug implements Rule
{
    /**
     * @var int|null
     */
    protected $ignoredRowId;
    
    /**
     * @var string
     */
    protected $lang;
    
    /**
     * @var int|null
     */
    protected $featureId;
    
    /**
     * FeatureValueMultilangSlug constructor.
     * @param string $lang
     * @param int|null $featureId
     * @param int|null $ignoredRowId
     */
    public function __construct(string $lang, ?int $featureId = null, ?int $ignoredRowId = null)
    {
        $this->lang = $lang;
        $this->featureId = $featureId;
        $this->ignoredRowId = $ignoredRowId;
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
        if (!$this->featureId) {
            return true;
        }
        return FeatureValueTranslates::whereHas('row.feature', function (Builder $builder) {
            $builder->where('id', $this->featureId);
        })->whereSlug($value)->whereLanguage($this->lang)->where('row_id', '!=', $this->ignoredRowId)->count() === 0;
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
}

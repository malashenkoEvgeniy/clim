<?php

namespace App\Traits;

use App\Rules\MultilangSlug;

/**
 * Trait ValidationRulesTrait
 *
 * @package App\Traits
 */
trait ValidationRulesTrait
{
    
    /**
     * Generate rules for form with multiple languages
     *
     * @param  array $oneLanguageRules
     * @param  array $multipleLanguageRules
     * @return array
     */
    public function generateRules(array $oneLanguageRules = [], array $multipleLanguageRules = []): array
    {
        $rules = $oneLanguageRules;
        $translatesRules = $multipleLanguageRules;
        foreach ($translatesRules AS $key => $localRules) {
            foreach (config('languages', []) AS $language) {
                foreach ($localRules AS $index => $rule) {
                    if ($rule instanceof MultilangSlug) {
                        $localRule = clone $rule;
                        $localRule->setLanguage($language['slug']);
    
                        $localRules[$index] = $localRule;
                    }
                }
                $rules[$language['slug'] . '.' . $key] = $localRules;
            }
        }
        return $rules;
    }
    
}

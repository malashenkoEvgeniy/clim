<?php

namespace App\Modules\Features\Components;

use App\Components\Catalog\Interfaces\FeatureInterface;
use App\Modules\Features\Models\Feature as FeatureModel;
use App\Modules\Features\Models\FeatureValue as FeatureValueModel;

/**
 * Class Feature
 *
 * @package App\Modules\Features\Facades
 */
class Feature implements FeatureInterface
{
    
    public function productMainFeatures(array $featuresAndValues): ?string
    {
        if (!$featuresAndValues) {
            return null;
        }
        $approvedFeatures = [];
        FeatureModel::whereIn('id', array_keys($featuresAndValues))
            ->active(true)
            ->whereMain(true)
            ->get()
            ->each(function (FeatureModel $feature) use (&$approvedFeatures) {
                $approvedFeatures[] = $feature->id;
            });
        if (!$approvedFeatures) {
            return null;
        }
        $uniqueValues = [];
        foreach ($approvedFeatures as $featureId) {
            $uniqueValues = array_merge($uniqueValues, array_get($featuresAndValues, $featureId, []));
        }
        $values = [];
        FeatureValueModel::with('current')
            ->whereIn('id', $uniqueValues)
            ->oldest('position')
            ->get()
            ->each(function (FeatureValueModel $value) use (&$values) {
                $values[$value->feature_id] = $values[$value->feature_id] ?? [];
                $values[$value->feature_id][] = $value->current->name;
            });
        $descriptions = [];
        foreach ($values as $vals) {
            $descriptions[] = implode(', ', $vals);
        }
        return implode(' / ', $descriptions);
    }
    
    public function productsFeatures(array $featuresAndValuesForProducts): array
    {
        $uniqueValues = [];
        foreach ($featuresAndValuesForProducts as $productId => $featuresAndValues) {
            foreach ($featuresAndValues as $featureId => $valuesIds) {
                $uniqueValues += array_keys($valuesIds);
            }
        }
        $uniqueValues = array_unique($uniqueValues);
        if (!$uniqueValues) {
            return [];
        }
        $values = [];
        FeatureValueModel::with('current')
            ->whereIn('id', $uniqueValues)
            ->oldest('position')
            ->get()
            ->each(function (FeatureValueModel $value) use (&$values) {
                $values[$value->id] = $value->current->name;
            });
        $resultArray = [];
        foreach ($featuresAndValuesForProducts as $productId => $featuresAndValuesForProduct) {
            foreach ($featuresAndValuesForProduct as $featureId => $valuesIds) {
                $productValues = [];
                foreach ($valuesIds as $valueId) {
                    if (isset($values[$valueId])) {
                        $productValues[] = $values[$valueId];
                    }
                }
                if (count($productValues) > 0) {
                    $resultArray[$productId] = $resultArray[$productId] ?? [];
                    $resultArray[$productId][] = implode(',', $productValues);
                }
            }
        }
        $descriptions = [];
        foreach ($resultArray as $productId => $values) {
            $descriptions[$productId] = implode(' / ', $values);
        }
        return $descriptions;
    }
    
    public function getClassName(): string
    {
        return FeatureModel::class;
    }
    
    public function getTableName(): string
    {
        return (new FeatureModel)->getTable();
    }
    
}

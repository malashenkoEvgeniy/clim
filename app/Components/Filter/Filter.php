<?php

namespace App\Components\Filter;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Route;

class Filter
{
    /**
     * @var Collection|FilterBlock[]
     */
    public $blocks;

    public $route;

    public $parameters;
    
    public $parametersIds;
    
    public function __construct()
    {
        $this->blocks = new Collection();
        $this->parameters = new Collection();
        $this->parametersIds = new Collection();
        $this->parseUrl();
    }

    /**
     * @return Collection
     */
    public function getFilterParametersFromQuery(): Collection
    {
        $parameters = new Collection();
        foreach ($this->parameters as $key => $values) {
            if ($this->hasParametersInFiltersList($key)) {
                $parameters->put($key, $values);
            }
        }
        return $parameters;
    }
    
    public function getFilterParametersIdsFromQuery(): Collection
    {
        $parameters = new Collection();
        foreach ($this->parametersIds as $key => $values) {
            if ($this->hasParametersIdsInFiltersList($key)) {
                $parameters->put($key, $values);
            }
        }
        return $parameters;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParametersInFiltersList(string $key): bool
    {
        foreach ($this->blocks as $block) {
            if ($key === $block->alias) {
                return true;
            }
        }
        return false;
    }
    
    public function hasParametersIdsInFiltersList($key = null): bool
    {
        foreach ($this->blocks as $block) {
            if ($key === $block->id || $key === $block->alias) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function getParametersAsArray(Collection $parametersToParse): array
    {
        $parameters = [];
        foreach ($parametersToParse as $parameterName => $parameterValue) {
            $parameters[$parameterName] = implode(',', $parameterValue);
        }
        return $parameters;
    }

    public function addBlock(string $name, string $alias, bool $showInFilter = true): FilterBlock
    {
        $block = new FilterBlock($name, $alias, $showInFilter);
        $this->blocks->push($block);

        return $block;
    }
    
    private function parseUrl(): void
    {
        foreach (request()->query as $key => $parameter) {
            if (is_string($parameter) && Str::length($parameter) > 0) {
                $this->parameters->put($key, explode(',', $parameter));
            }
        }
    }
    
    public function generateIds(): void
    {
        foreach (request()->query as $key => $parameter) {
            foreach ($this->blocks as $block) {
                if ($block->alias !== $key) {
                    continue;
                }
                $elementIds = [];
                foreach ($block->getElements() as $element) {
                    if (in_array($element->alias, explode(',', $parameter)) === false) {
                        continue;
                    }
                    $elementIds[] = $element->id;
                }
                $this->parametersIds->put($block->id ?: $block->alias, $elementIds);
            }
        }
    }

    public function all()
    {
        return $this;
    }
    
    public function chosen(string $parameterAlias, string $valueAlias): bool
    {
        return in_array($valueAlias, array_get($this->parameters, $parameterAlias, []));
    }
    
    public function oneOfElementsChosen(string $parameterAlias): bool
    {
        if (!isset($this->parameters[$parameterAlias])) {
            return false;
        }
        $block = $this->getBlock($parameterAlias);
        if (!$block) {
            return false;
        }
        foreach ($block->getElements() as $element) {
            if ($element->selected) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|FilterBlock[]
     */
    public function getBlocks()
    {
        return $this->blocks->sortBy('position');
    }
    
    public function hasBlock(string $blockAlias): bool
    {
        return !!$this->getBlocksWithKey()->get($blockAlias);
    }
    
    public function getBlocksWithKey()
    {
        return $this->getBlocks()->keyBy('alias');
    }
    
    public function getBlocksWithIdAsKey()
    {
        return $this->getBlocks()->keyBy('id');
    }
    
    public function getBlock(string $blockAlias): ?FilterBlock
    {
        return $this->getBlocksWithKey()->get($blockAlias);
    }
    
    public function getBlockById(?int $id): ?FilterBlock
    {
        return $this->getBlocksWithIdAsKey()->get((int)$id);
    }

    public function linkWith(string $parameter, string $value)
    {
        $parameters = clone $this->parameters;
        $values = $parameters->get($parameter, []);
        $values[] = $value;
        $parameters->put($parameter, $values);
        return $this->generateUrl($this->getParametersAsArray($parameters));
    }

    public function linkWithSitemap(string $parameter, string $value, string $route, array $categoryParams)
    {
        $parameters = clone $this->parameters;
        $values = $parameters->get($parameter, []);
        $values[] = $value;
        $parameters->put($parameter, $values);
        return $this->generateSitemapUrl($route, $categoryParams, $this->getParametersAsArray($parameters));
    }

    public function linkWithout(string $parameter, string $value)
    {
        if (!$this->parameters->has($parameter)) {
            return $this->generateUrl($this->getParametersAsArray($this->parameters));
        }
        $parameters = clone $this->parameters;
        $values = $parameters->get($parameter);
        $values = array_filter($values, function ($element) use ($value) {
            return $element !== $value;
        });
        if (empty($values)) {
            $parameters->forget($parameter);
        } else {
            $parameters->put($parameter, $values);
        }
        return $this->generateUrl($this->getParametersAsArray($parameters));
    }
    
    /**
     * @param array $queryParameters
     * @return string
     */
    public function generateUrl(array $queryParameters): string
    {
        $parameters = Route::current()->parameters();
        unset($parameters['pageQuery']);
        $queryParameters = $queryParameters ? '?' . http_build_query($queryParameters) : '';
        return route(
            $this->getRoute(),
            $parameters
        ) . $queryParameters;
    }

    public function generateSitemapUrl(string $route, array $parameters, array $queryParameters): string
    {
        $queryParameters = $queryParameters ? '?' . http_build_query($queryParameters) : '';
        return route(
            $route,
            $parameters
        ) . $queryParameters;
    }

    /**
     * @return mixed
     */
    public function getRoute(): ?string
    {
        return $this->route ?? Route::currentRouteName();
    }

    /**
     * @param mixed $route
     * @return self
     */
    public function setRoute($route): self
    {
        $this->route = $route;

        return $this;
    }
    
    /**
     * @param array $counters
     */
    public function setCounters(array $counters): void
    {
        $blocks = $this->getBlocksWithIdAsKey();
        foreach ($counters as $parameter => $values) {
            if (is_array($values) === false || $blocks->has($parameter) === false) {
                continue;
            }
            /** @var FilterBlock $block */
            $block = $blocks->get($parameter);
            $elements = $block->getElementsWithIdAsKey();
            foreach ($values as $value => $count) {
                if ($elements->has($value)) {
                    $block->addCount($count);
                    $elements->get($value)->addCount($count);
    
                    $block->addFilteredCount($count);
                    $elements->get($value)->addFilteredCount($count);
                }
            }
        }
    }
    
    /**
     * @param array $counters
     */
    public function setFilteredCounters(array $counters): void
    {
        $blocks = $this->getBlocksWithIdAsKey();
        foreach ($counters as $parameter => $values) {
            if (is_array($values) === false || $blocks->has($parameter) === false) {
                continue;
            }
            /** @var FilterBlock $block */
            $block = $blocks->get($parameter);
            $elements = $block->getElementsWithIdAsKey();
            foreach ($values as $value => $count) {
                if ($elements->has($value)) {
                    $block->addFilteredCount($count);
                    $elements->get($value)->addFilteredCount($count);
                }
            }
        }
    }
    
    public function duplicateCounterToFilteredCounter(?int $blockId): void
    {
        if (!$blockId) {
            return;
        }
        $block = $this->getBlockById($blockId);
        $block->elements->each(function (FilterElement $element) {
            $element->filteredCount = $element->count;
        });
        $block->filteredCount = $block->count;
    }
    
    public function getValueName(int $featureId, int $valueId): ?string
    {
        foreach ($this->getBlocks() as $block) {
            if ($block->id !== $featureId) {
                continue;
            }
            foreach ($block->getElements() as $element) {
                if ($element->id !== $valueId) {
                    continue;
                }
                return $element->name;
            }
        }
        return null;
    }
}

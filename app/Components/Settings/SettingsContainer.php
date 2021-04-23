<?php

namespace App\Components\Settings;

use App\Exceptions\WrongParametersException;
use Illuminate\Support\Collection;

/**
 * This class controls all modules settings
 *
 * @package App\Components\Settings
 */
class SettingsContainer
{
    
    /**
     * @var Collection|SettingsGroup[]
     */
    private $elements;
    
    /**
     * SettingsContainer constructor.
     */
    public function __construct()
    {
        $this->elements = new Collection();
    }
    
    /**
     * Get all groups
     *
     * @return SettingsGroup[]|Collection
     */
    public function groups(): array
    {
        $elements = $this->elements->toArray();
        usort($elements, function (SettingsGroup $current, SettingsGroup $next) {
            return $current->getPosition() <=> $next->getPosition();
        });
        return $elements;
    }
    
    /**
     * Returns exemplar of class SettingsGroup from the groups list
     * This method will create group first if it does not exist
     *
     * @param  string $alias
     * @param  string|null $name
     * @param  int $position
     * @return SettingsGroup
     */
    public function createAndGet(string $alias, string $name = null, int $position = 0): SettingsGroup
    {
        if ($this->doesGroupExist($alias) === false) {
            $this->elements->put($alias, new SettingsGroup($alias, $name ?? $alias, $position));
        }
        return $this->elements->get($alias);
    }
    
    /**
     * Check group for existence in the storage
     *
     * @param  string $alias
     * @return bool
     */
    public function doesGroupExist(string $alias): bool
    {
        return $this->elements->has($alias);
    }
    
    /**
     * Get setting element
     *
     * @param  string $alias
     * @param  null|mixed $default
     * @return mixed|null|SettingsElement|SettingsGroup
     * @throws WrongParametersException
     */
    public function get(string $alias, $default = null)
    {
        $aliasParts = explode('.', $alias);
        if (count($aliasParts) < 1 || count($aliasParts) > 2) {
            throw new WrongParametersException('Wrong alias!');
        }
        if (count($aliasParts) === 1) {
            return $this->elements->get($alias, $default);
        }
        if ($this->doesGroupExist($aliasParts[0])) {
            return $this->elements->get($aliasParts[0])->get($aliasParts[1], $default);
        }
        return $default;
    }
    
    /**
     * Get setting value
     *
     * @param  string $alias
     * @param  null $default
     * @return SettingsElement|SettingsGroup|mixed|null
     * @throws WrongParametersException
     */
    public function getValue(string $alias, $default = null)
    {
        $element = $this->get($alias, $default);
        if ($element instanceof SettingsElement) {
            return $element->getValue() ?? $default;
        }
        return $element;
    }
    
}

<?php

namespace CustomForm\Builder;

use Illuminate\Support\Collection;

/**
 * Class Tabs
 *
 * @package App\Components\Form\Builder
 */
class Tabs
{
    /**
     * @var Collection|Tab[]
     */
    protected $collection;
    
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var int
     */
    protected $width;
    
    /**
     * Tab constructor.
     *
     * @param int $width
     * @param null|string $id
     * @throws \Exception
     */
    public function __construct(int $width = 12, ?string $id = null)
    {
        $this->collection = new Collection;
        $this->id = (string)$id ?: 'tabs_' . random_int(100000, 999999);
        $this->width = $width;
    }
    
    /**
     * @param Tab $tab
     * @return Tab
     */
    public function addTab(Tab $tab): Tab
    {
        $this->collection->push($tab);
        
        return $tab;
    }
    
    /**
     * @param string $name
     * @param null|string $id
     * @return Tab
     * @throws \Exception
     */
    public function createTab(string $name, ?string $id = null): Tab
    {
        $tab = new Tab($name, $id);
        $this->addTab($tab);
        
        return $tab;
    }
    
    /**
     * @return Collection|Tab[]
     */
    public function getTabs(): Collection
    {
        return $this->collection;
    }
    
}
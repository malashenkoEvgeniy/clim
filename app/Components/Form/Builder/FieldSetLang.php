<?php

namespace CustomForm\Builder;

use CustomForm\Element;
use CustomForm\Group\Group;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class FieldSet
 * Field set of form elements
 *
 * @package CustomForm\Builder
 */
class FieldSetLang
{
    
    // Box colors
    const COLOR_DEFAULT = 'box-default';
    const COLOR_SUCCESS = 'box-success';
    const COLOR_WARNING = 'box-warning';
    const COLOR_DANGER = 'box-danger';
    const COLOR_PRIMARY = 'box-primary';
    
    /**
     * Number from 1 to 12
     * By default - 12
     *
     * @var int
     */
    private $width;
    
    /**
     * By default - COLOR_DEFAULT
     *
     * @var null|string
     */
    private $color;
    
    /**
     * Field set title
     *
     * @var null|string
     */
    private $title;
    
    /**
     * Fields for current field set
     *
     * @var Collection|Element[]
     */
    private $formFields;
    
    /**
     * Unique ID for languages tabs
     *
     * @var string
     */
    private $uid;
    
    /**
     * Do we need to use boxes
     *
     * @var bool
     */
    private $boxed = true;
    
    /**
     * FieldSet constructor.
     *
     * @param int $width
     * @param null $color
     * @param null $title
     */
    public function __construct(int $width = 12, $color = null, $title = null)
    {
        // Set width
        $this->width = $width < 0 || $width > 12 ? 12 : $width;
        // Set color class
        $this->color = $color ?? static::COLOR_DEFAULT;
        // Set title for field set
        $this->title = $title;
        // Generate collection for fields
        $this->formFields = new Collection();
        
        $this->uid = Str::uuid();
    }
    
    /**
     * @param bool $boxed
     * @return FieldSetLang
     */
    public function boxed(bool $boxed): FieldSetLang
    {
        $this->boxed = $boxed;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isBoxed(): bool
    {
        return $this->boxed;
    }
    
    /**
     * Add field to field set
     *
     * @param  Element[] $elements
     * @return $this
     */
    public function add(Element ...$elements)
    {
        $fieldSet = $this;
        foreach (config('languages', new Collection()) as $language) {
            // Add fields to field set
            $fieldSetForLang = $fieldSet->formFields->get($language->name, []);
            foreach ($elements as $element) {
                $morphElement = clone $element;
                $morphElement->setLanguage($language->slug);
                if ($morphElement instanceof Group) {
                    foreach ($morphElement->getElements() as $childElement) {
                        $childElement->setLanguage($language->slug);
                    }
                }
                $fieldSetForLang[] = $morphElement;
            }
            $fieldSet->formFields->put($language->slug, $fieldSetForLang);
        }
        // Return field set object
        return $this;
    }
    
    /**
     * Returns color class
     *
     * @return null|string
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * Returns width
     * This is a number from 1 to 12
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * Returns field set title
     *
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Returns fields collection
     *
     * @return Element[]|Collection
     */
    public function getFields()
    {
        return $this->formFields;
    }
    
    /**
     * Returns form field set id
     *
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }
    
}

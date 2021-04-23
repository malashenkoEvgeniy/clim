<?php

namespace CustomForm\Builder;

use App\Exceptions\WrongParametersException;
use CustomForm\Element;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Form as FormCollective;

/**
 * Class Form
 * Form block in custom builder
 *
 * @package CustomForm\Builder
 */
class Form
{
    /**
     * Send form by ajax request?
     *
     * @var bool
     */
    private $ajax = false;
    
    /**
     * Form template
     *
     * @var string
     */
    private $template = 'admin.form.layouts.simple';

    /**
     * Filter form template
     *
     * @var string
     */
    private $filter_template = 'admin.form.layouts.filter';

    /**
     * Form field sets
     *
     * @var Collection|FieldSet[]|FieldSetLang[]|FieldSetSimple[]|ViewSet[]|Tabs[]
     */
    private $fieldSets;

    /**
     * Our form buttons list
     *
     * @var Buttons
     */
    public $buttons;

    /**
     * Do we need to show buttons on the bottom of the form
     *
     * @var bool
     */
    public $showBottomButtons = true;

    /**
     * Do we need to show buttons on the top of the form
     *
     * @var bool
     */
    public $showTopButtons = true;

    /**
     * Form constructor.
     */
    public function __construct()
    {
        // Create field sets collection
        $this->fieldSets = new Collection();
        // Create buttons model
        $this->buttons = new Buttons();
    }
    
    /**
     * @return Form
     */
    public function ajax(): self
    {
        $this->ajax = true;
    
        $this->buttons->doNotShowSaveAndAddButton();
        $this->buttons->doNotShowSaveAndCloseButton();
        $this->doNotShowTopButtons();
        
        return $this;
    }

    /**
     * Do not show bottom buttons
     *
     * @return $this
     */
    public function doNotShowBottomButtons()
    {
        $this->showBottomButtons = false;

        return $this;
    }

    /**
     * Show bottom buttons
     *
     * @return $this
     */
    public function showBottomButtons()
    {
        $this->showBottomButtons = true;

        return $this;
    }

    /**
     * Do not show top buttons
     *
     * @return $this
     */
    public function doNotShowTopButtons()
    {
        $this->showTopButtons = false;

        return $this;
    }

    /**
     * Show top buttons
     *
     * @return $this
     */
    public function showTopButtons()
    {
        $this->showTopButtons = false;

        return $this;
    }
    
    /**
     * @return FieldSetSimple
     */
    public function simpleFieldSet()
    {
        // Create field set
        $fieldSet = new FieldSetSimple();
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }

    /**
     * @param  int $width
     * @param  string|null $color
     * @param  string|null $title
     * @return FieldSet
     */
    public function fieldSet(int $width = 12, $color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSet($width, $color, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param FieldSet $fieldSet
     * @return FieldSet
     */
    public function addFieldSet(FieldSet $fieldSet): FieldSet
    {
        $this->fieldSets->push($fieldSet);
        
        return $fieldSet;
    }
    
    /**
     * @param  int $width
     * @param  string|null $color
     * @param  string|null $title
     * @return FieldSetLang
     */
    public function fieldSetForLang(int $width = 12, $color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSetLang($width, $color, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }

    /**
     * @param FieldSetLang $fieldSet
     * @return FieldSetLang
     */
    public function addFieldSetForLang(FieldSetLang $fieldSet): FieldSetLang
    {
        $this->fieldSets->push($fieldSet);
        
        return $fieldSet;
    }
    
    /**
     * @param null $color
     * @param null $title
     * @return FieldSet
     */
    public function fieldSetForFilter($color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSet(0, $color ?? FieldSet::COLOR_PRIMARY, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param int $width
     * @param string $path
     * @param array $params
     * @return ViewSet
     */
    public function fieldSetForView($path, $params= [], int $width = 12)
    {
        // Create field set
        $viewSet = new ViewSet($path, $params, $width);
        // Store it
        $this->fieldSets->push($viewSet);
        // Return it to main function
        return $viewSet;
    }
    
    /**
     * @param int $width
     * @param null|string $id
     * @return Tabs
     * @throws \Exception
     */
    public function tabs(int $width = 12, ?string $id = null): Tabs
    {
        // Create field set
        $tabs = new Tabs($width, $id);
        // Store it
        $this->fieldSets->push($tabs);
        // Return it to main function
        return $tabs;
    }

    /**
     * Creates & returns Form instance
     *
     * @return Form
     */
    static function create()
    {
        return new Form();
    }

    /**
     * Just open form
     *
     * @param  array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function open(array $options = [])
    {
        return FormCollective::open($options);
    }

    /**
     * Just close form
     *
     * @return string
     */
    public function close()
    {
        return FormCollective::close();
    }

    /**
     * Returns all field sets
     *
     * @return FieldSet[]|Collection
     */
    public function getFieldSets()
    {
        return $this->fieldSets;
    }

    /**
     * Render form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view($this->template, ['form' => $this]);
    }

    /**
     * Render form in filter template
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderAsFilter()
    {
        return view($this->filter_template, ['form' => $this]);
    }

    /**
     * Create form from settings in array
     *
     * @param  Model|null $object
     * @param  mixed ...$settings
     * @return Form
     * @throws WrongParametersException
     */
    static function createFromArray($object = null, ...$settings)
    {
        // Create form
        $form = Form::create();
        // Add field sets
        foreach ($settings as $fieldSetSettings) {
            if (array_get($fieldSetSettings, 'i18n')) {
                // Create multiple languages field set
                $fieldSet = $form->fieldSetForLang(
                    array_get($fieldSetSettings, 'width', 12),
                    array_get($fieldSetSettings, 'color', FieldSet::COLOR_DEFAULT),
                    array_get($fieldSetSettings, 'title')
                );
            } else {
                // Create field set
                $fieldSet = $form->fieldSet(
                    array_get($fieldSetSettings, 'width', 12),
                    array_get($fieldSetSettings, 'color', FieldSet::COLOR_DEFAULT),
                    array_get($fieldSetSettings, 'title')
                );
            }
            // Get fields settings
            $fieldsSettings = array_get($fieldSetSettings, 'elements', []);
            // Validate
            if (!is_array($fieldsSettings)) {
                throw new WrongParametersException('Please specify `elements` in form field set configuration correctly');
            }
            // Add fields to field sets
            foreach ($fieldsSettings as $fieldSettings) {
                // Force push to field set if field is instance of Element
                if ($fieldSettings instanceof Element) {
                    $fieldSet->add($fieldSettings);
                    continue;
                }
                // Validate
                if (!is_array($fieldSettings)) {
                    throw new WrongParametersException('Please specify `elements` in form field set configuration correctly');
                }
                if (!isset($fieldSettings['class']) || !is_string($fieldSettings['class']) || !class_exists($fieldSettings['class'])) {
                    throw new WrongParametersException('Please specify `elements`.`class` in form field set configuration correctly');
                }
                // Get class namespace
                $className = $fieldSettings['class'];
                // Create element and add it to field set
                $fieldSet->add($className::createFromArray($object, $fieldSettings));
            }
        }
        // Return created Form instance
        return $form;
    }

}

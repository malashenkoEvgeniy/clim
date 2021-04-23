<?php

namespace CustomForm;

use App\Exceptions\WrongParametersException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lang;

/**
 * Class Element
 * Base part of all form elements
 *
 * @package CustomForm
 */
abstract class Element
{

    /**
     * View
     *
     * @var string
     */
    protected $template;

    /**
     * Name attribute of the element
     *
     * @var string
     */
    protected $name;

    /**
     * Key via Laravel can get error message after failed submit
     *
     * @var string
     */
    protected $errorSessionKey;

    /**
     * Additional options on form element
     *
     * @var array
     */
    protected $options = [];

    /**
     * Additional options on a block
     *
     * @var array
     */
    protected $blockOptions = [];

    /**
     * Label text
     *
     * @var string|null
     */
    protected $label;

    /**
     * Placeholder on element
     *
     * @var string|null
     */
    protected $placeholder;

    /**
     * Value
     *
     * @var int|null|string|array
     */
    protected $value;

    /**
     * Default value
     *
     * @var int|null|string|array
     */
    protected $defaultValue;

    /**
     * Our model from database
     *
     * @var null|Model
     */
    protected $object;

    /**
     * Help message
     *
     * @var string|null
     */
    protected $help;

    /**
     * Type of the element
     *
     * @var string
     */
    protected $type = 'text';

    /**
     * Classes list on the element
     *
     * @var array
     */
    protected $classes = ['form-control'];

    /**
     * Classes list on the closest div block of the element
     *
     * @var array
     */
    protected $classesOnDiv = ['form-group'];

    /**
     * @var string
     */
    protected $valueMethod;

    /**
     * @var string
     */
    protected $jsonKey = null;

    /**
     * Element constructor.
     *
     * @param  string $name
     * @param  null $object
     * @throws WrongParametersException|\Exception
     */
    public function __construct(string $name, $object = null)
    {
        if (!$name || !is_string($name)) {
            throw new WrongParametersException('`name` parameter is required');
        }
        $this->name = $name;
        $this->setJson();
        $this->setObject($object);
        $this->errorSessionKey = str_replace(['[', ']'], '', $name);
        $this->label = Lang::has('validation.attributes.' . $name) ?
                __('validation.attributes.' . $name) :
                Str::ucfirst(str_replace(['_', '[', ']'], ' ', $name));

        $this->options['id'] = $this->errorSessionKey  . random_int(1000, 999999);
    }

    public function setJson()
    {
        $arr = explode('.', $this->name);
        if (count($arr) > 1) {
            $this->name = $arr[0];
            $this->jsonKey = $arr[1];
        }
    }

    /**
     * Create method
     * Does the same that __construct but via static method
     * Useful for chains
     *
     * @param  string $name
     * @param  null $object
     * @return static
     * @throws WrongParametersException
     */
    static function create(string $name, $object = null)
    {
        return new static($name, $object);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get error session key
     *
     * @return mixed|string
     */
    public function getErrorSessionKey()
    {
        return $this->errorSessionKey;
    }

    /**
     * Set current model
     *
     * @param Model|null $object
     * @return self|null
     */
    public function setObject(?Model $object): self
    {
        $this->object = $object;
        $this->value = old($this->name, $object->{$this->name} ?? null);
        return $this;
    }

    /**
     * Get current model
     *
     * @return Model|null
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set custom options
     *
     * @param  array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options + $this->options;

        return $this;
    }

    /**
     * Set custom options to a block
     *
     * @param  array $options
     * @return $this
     */
    public function setBlockOptions(array $options)
    {
        $this->blockOptions = $options + $this->blockOptions;

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge([
            'class' => $this->classes,
            'placeholder' => $this->placeholder,
                ], $this->options);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getBlockOptions()
    {
        return array_merge([
            'class' => $this->classesOnDiv,
        ], $this->blockOptions);
    }

    /**
     * Changes name via language
     * Useful for names like: ua[name], en[title] etc.
     *
     * @param  string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->errorSessionKey = $language . '.' . $this->name;
        if ($this->object && method_exists($this->object, 'dataFor') && isset($this->object->dataFor($language)->{$this->name})
        ) {
            $this->value = $this->object->dataFor($language)->{$this->name};
        }
        $this->name = $language . '[' . ($this->jsonKey ?: $this->name) . ']';
        $this->options['id'] .= '-' . $language;

        return $this;
    }

    /**
     * Set custom value
     *
     * @param  int|null|string|array $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int|null|string|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set custom value
     *
     * @param  int|null|string|array $value
     * @return $this
     */
    public function setDefaultValue($value): self
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int|null|string|array
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set type
     *
     * @param  string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     * `text` by default
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set custom text on label
     *
     * @param  string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return null|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set helper message
     *
     * @param  string $helper
     * @return $this
     */
    public function setHelp(string $helper)
    {
        $this->help = $helper;

        return $this;
    }

    /**
     * Get helper message
     *
     * @return null|string
     */
    public function getHelp()
    {
        return __($this->help);
    }

    /**
     * Set custom placeholder
     *
     * @param  string $placeholder
     * @return $this
     */
    public function setPlaceholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get placeholder
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set custom classes on element
     *
     * @param  string[] ...$classes
     * @return $this
     */
    public function addClasses(...$classes)
    {
        $this->classes = array_merge($this->classes, $classes);

        return $this;
    }

    /**
     * Add class .required to element
     *
     * @return $this
     */
    public function required()
    {
        $this->options[] = 'required';

        return $this;
    }

    /**
     * Get custom classes on element
     *
     * @return string
     */
    public function getClass()
    {
        return implode(' ', $this->classes);
    }

    /**
     * Set custom classes on parent block
     *
     * @param  mixed ...$classes
     * @return $this
     */
    public function addClassesToDiv(...$classes)
    {
        $this->classesOnDiv = array_merge($this->classesOnDiv, $classes);

        return $this;
    }

    /**
     * Get custom classes on parent block
     *
     * @return string
     */
    public function getClassToDiv()
    {
        return implode(' ', $this->classesOnDiv);
    }

    /**
     * Render element
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if ($this->value === null && $this->defaultValue !== null) {
            $this->value = $this->defaultValue;
        }
        if ($this->object && $this->getValueMethod()) {
            $this->value = $this->object->{$this->getValueMethod()};
        }
        if($this->object && $this->jsonKey){
            $temp = json_decode($this->value,true);
            $this->value = $temp[$this->jsonKey];
        }

        return view($this->template, ['element' => $this]);
    }

    /**
     * Check if element required
     *
     * @return bool
     */
    public function isRequired()
    {
        return in_array('required', $this->options) || array_get($this->options, 'required', false);
    }

    /**
     * Make element from the settings in array
     *
     * @param  null $object
     * @param  array $settings
     * @return Element|Input|Select|TextArea|TinyMce|Image
     * @throws WrongParametersException
     */
    static function createFromArray($object = null, array $settings)
    {
        if (!isset($settings['name']) || !is_string($settings['name'])) {
            throw new WrongParametersException('Please specify `elements`.`name` in form field set configuration correctly');
        }
        $field = static::create($settings['name'], $object);
        $methods = [
            'type' => 'setType',
            'label' => 'setLabel',
            'options' => 'setOptions',
            'block-options' => 'setBlockOptions',
            'language' => 'setLanguage',
            'value' => 'setValue',
            'help' => 'setHelp',
            'placeholder' => 'setPlaceholder',
            'class' => 'addClasses',
            'block-class' => 'addClassesToDiv',
        ];
        foreach ($settings as $key => $value) {
            if (array_key_exists($key, $methods)) {
                call_user_func([$field, $methods[$key]], $value);
            }
        }
        return $field;
    }

    /**
     * Returns valueFieldRelation
     *
     * @return string
     */
    public function getValueMethod()
    {
        return $this->valueMethod;
    }

    /**
     * Returns valueFieldRelation
     *
     * @return self
     */
    public function setValueMethod(string $method): self
    {
        $this->valueMethod = $method;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->render();
    }

}

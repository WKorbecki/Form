<?php

namespace WKorbecki\Form;

use WKorbecki\Form\Traits\Element\AttributeTrait;
use WKorbecki\Form\Traits\Element\RenderTrait;

abstract class Element {
    use AttributeTrait;
    use RenderTrait;

    private string $hash = '';
    protected ?string $group = null;
    protected string $id = '';
    protected string $name = '';
    protected string $type = 'text';
    protected ?string $label = null;
    protected string $label_class = '';
    protected string $placeholder = '';
    protected string $class = '';
    protected $value = null;
    protected array $options = [];
    protected array $data = [];
    protected array $attributes = [];
    protected $validation = '';
    protected bool $multi_value = false;
    protected array $messages = [];
    protected array $errors = [];
    protected ?string $custom_view_label = null;
    protected ?string $custom_view_element = null;
    protected ?string $custom_view_group = null;
    protected array $prepend = [];
    protected array $append = [];
    protected bool $value_attribute_exclude = false;
    private int $valid = 0;

    public function __construct(string $name, array $data) {
        $this->init($name, $data);
    }

    protected function init(string $name, array $data) {
        $this->name = $name;
        $this->group = $data['group'] ?? $this->group;
        $this->label = $data['label'] ?? $this->label;
        $this->label_class = $data['label_class'] ?? $this->label_class;
        $this->placeholder = $data['placeholder'] ?? $data['label'] ?? $this->placeholder;
        $this->class = $data['class'] ?? $this->class;
        $this->value = $data['value'] ?? $this->value;
        $this->options = $data['options'] ?? $this->options;
        $this->data = $data['data'] ?? $this->data;
        $this->attributes = [$data['attr'] ?? $this->attributes];
        $this->validation = $data['validation'] ?? $this->validation;
        $this->prepend = $data['prepend'] ?? $this->prepend;
        $this->append = $data['append'] ?? $this->append;
        $this->multi_value = $data['multi_value'] ?? $this->multi_value;
        $this->messages = $data['messages'] ?? $this->messages;
        $this->custom_view_label = $data['custom_view_label'] ?? $this->custom_view_label;
        $this->custom_view_element = $data['custom_view_element'] ?? $this->custom_view_element;
        $this->custom_view_group = $data['custom_view_group'] ?? $this->custom_view_group;
        $this->attributes['id'] = $this->fieldId($this->group, $data['id'] ?? $data['name'] ?? $this->id);
        $this->attributes['name'] = $this->fieldName($this->group, $data['name'] ?? $this->name);
    }

    abstract public static function make(
        string $name = '',
        string $type = 'text',
        ?string $group = null,
        ?string $label = null,
        string $label_class = '',
        string $placeholder = '',
        string $class = '',
        array $options = [],
        array $data = [],
        array $attributes = [],
        $validation = '',
        bool $multi_value = false,
        $value = null,
        array $messages = [],
        ?string $custom_view_label = null,
        ?string $custom_view_element = null,
        ?string $custom_view_group = null
    );

    public function toArray() : array {
        return [
            'hash' => $this->hash,
            'group' => $this->group,
            'type' => $this->type,
            'label' => $this->label,
            'label_class' => $this->label_class,
            'placeholder' => $this->placeholder,
            'class' => $this->class,
            'value' => $this->value,
            'options' => $this->options,
            'data' => $this->data,
            'attr' => $this->attributes,
            'validation' => $this->validation,
            'prepend' => $this->prepend,
            'append' => $this->append,
            'multi_value' => $this->multi_value,
        ];
    }

    public function populate($value) {
        if ($this->valid != -1) {
            $this->value = $value;
        }
    }

    public function value() {
        return $this->value;
    }

    public function group() : ?string {
        return $this->group;
    }

    public function isGroup($group) : bool {
        return $group === $this->group;
    }

    public function setErrors($errors) {
        $this->errors = $errors;

        $this->valid = count($errors) == 0 ? 1 : -1;
    }

    public function rules() {
        return $this->validation;
    }

    public function messages() {
        return $this->messages;
    }

    public function request_name() : string {
        return ($this->group ? ($this->group . '.') : '') . $this->name;
    }

    public function name() : string {
        return $this->name;
    }
}

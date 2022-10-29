<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;
use WKorbecki\Form\Enum\ElementType;

class Input extends Element {
    protected string $type = 'text';

    public function __construct(string $hash, string $type, array $data){
        parent::__construct($hash, $data);
        $this->type = $type;

        if (in_array($type, [ElementType::File, ElementType::Password])) {
            $this->value_attribute_exclude = true;
        }
    }

    public static function make(
        string $name = '',
        string $type = 'text',
        ?string $group = null,
        ?string $label = null,
        string $label_class = '',
        string $placeholder = '',
        string $class = '',
        array $data = [],
        array $attributes = [],
        $validation = '',
        $value = null,
        array $messages = [],
        ?string $custom_view_label = null,
        ?string $custom_view_element = null,
        ?string $custom_view_group = null
    ) : Input {
        return new self($name, $type, [
            'group' => $group,
            'label' => $label,
            'label_class' => $label_class
        ]);
    }

    public function renderElement($default = null) : string {
        return '<input type="' . $this->type . '" ' . $this->attributes($default) . '>';
    }
}

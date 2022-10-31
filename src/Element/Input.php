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

    public function renderElement($default = null) : string {
        return '<input type="' . $this->type . '" ' . $this->attributes($default) . '>';
    }
}

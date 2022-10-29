<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;

class TextArea extends Element {
    protected string $type = 'textarea';
    protected bool $value_attribute_exclude = true;

    public function renderElement($default = null) : string {
        return '<textarea ' . $this->attributes($default) . '>' . $this->value . '</textarea>';
    }
}

<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;
use WKorbecki\Form\Traits\Element\SelectOptionTrait;

class Select extends Element {
    use SelectOptionTrait;

    protected string $type = 'select';
    protected bool $value_attribute_exclude = true;

    public function renderElement($default = null) : string {
        return '<select ' . $this->attributes($default) . '>' . $this->options() . '</select>';
    }
}

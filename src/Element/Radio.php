<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;
use WKorbecki\Form\Traits\Element\RadioOptionTrait;

class Radio extends Element {
    use RadioOptionTrait;

    protected string $type = 'radio';
    protected bool $value_attribute_exclude = true;

    public function renderElement($default = null) : string {
        return $this->options($default);
    }
}

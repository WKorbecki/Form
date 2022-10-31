<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;

class Checkbox extends Element {
    protected string $type = 'checkbox';

    public function renderElement($default = null) : string {
        return "<input type=\"hidden\" name=\"{$this->name}\" value=\"0\">
                <input type=\"checkbox\" {$this->attributes($default)}>";
    }

    public function render($default = null) : string {
        return $this->custom_view_group ?
            view($this->custom_view_group, $this->toArray())->render() :
            implode("\n", [
                '<div class="form-group">',
                '<div class="form-check">',
                $this->renderElement($default),
                $this->renderLabel(),
                '</div>',
                $this->renderErrors(),
                '</div>',
            ]);
    }

    protected function valueAttribute(array &$elements, $default = null) {
        $elements[] = 'value="1"';

        if (($this->value ?? $default) == 1){
            $elements[] = 'checked="checked"';
        }
    }
}

<?php

namespace WKorbecki\Form\Element;

use WKorbecki\Form\Element;

class Checkbox extends Element {
    protected string $type = 'checkbox';

    public function renderElement($default = null) : string {
        return "<input type=\"hidden\" name=\"{$this->attributes['name']}\" value=\"0\">
                <input type=\"checkbox\" {$this->attributes($default)}>";
    }

    protected function valueAttribute(array &$elements, $default = null) {
        $elements[] = 'value="1"';

        if (($this->value ?? $default) == 1){
            $elements[] = 'checked="checked"';
        }
    }

    protected function renderBootstrap4($default = null) : string {
        return implode("\n", [
            '<div class="form-group">',
            '<div class="custom-control custom-checkbox">',
            $this->renderElement($default),
            $this->renderLabel(),
            '</div>',
            $this->renderErrors(),
            '</div>',
        ]);
    }

    protected function renderBootstrap5($default = null) : string {
        return implode("\n", [
            '<div class="form-group">',
            '<div class="form-check">',
            $this->renderElement($default),
            $this->renderLabel(),
            '</div>',
            $this->renderErrors(),
            '</div>',
        ]);
    }
}

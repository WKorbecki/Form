<?php

namespace WKorbecki\Form\Traits\Form;

trait RenderTrait {
    public function renderElement($name, $default = null) : string {
        return isset($this->elements[$name]) ? $this->elements[$name]->renderElement($default) : '';
    }

    public function renderLabel($name) : string {
        return isset($this->elements[$name]) ? $this->elements[$name]->renderLabel() : '';
    }

    public function render($name, $default = null) : string {
        return isset($this->elements[$name]) ? $this->elements[$name]->render($default) : '';
    }
}

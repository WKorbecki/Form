<?php

namespace WKorbecki\Form\Traits\Element;

trait AttributeTrait {
    private function elementAttributes($items, $prefix = '') : string {
        $html = [];

        foreach ($items as $key => $value){
            $html[] = $prefix . $key . '="' . $value . '"';
        }

        return implode(' ', $html);
    }

    private function fieldId(?string $group, string $name) : string {
        return ($group ? ($group . '-') : '') . str_replace('.', '-', $name);
    }

    private function fieldName(?string $group, string $name) : string {
        $name = explode('.', $name);
        $main_name = $name[0];
        unset($name[0]);
        $name = str_replace('[]', '', '[' . implode('][', array_values($name)) . ']');

        if ($group){
            $main_name = $group . '[' . $main_name . ']';
        }

        if ($this->multi_value){
            $name .= '[]';
        }

        return $main_name . $name;
    }

    private function fieldClass() : string {
        $classes = explode(' ', $this->class);

        foreach ($classes as $i => $class){
            if (empty($class)){
                unset($classes[$i]);
            }
        }

        if ($this->valid == 1){
            $classes[] = 'is-valid';
        }
        elseif ($this->valid == -1){
            $classes[] = 'is-invalid';
        }

        return implode(' ', $classes);
    }

    protected function valueAttribute(array & $elements, $default = null) {
        if (!($this->multi_value || $this->value_attribute_exclude)){
            $elements[] = 'value="' . ($this->value ?? $default) . '"';
        }
    }

    protected final function attributes($default = null) : string {
        $elements = [
            'id="' . $this->id . '"',
            'name="' . $this->name . '"',
        ];

        if ($class = $this->fieldClass()){
            $elements[] = 'class="' . $class . '"';
        }

        if ($attributes = $this->elementAttributes($this->attributes)){
            $elements[] = $attributes;
        }

        if ($data = $this->elementAttributes($this->data, 'data-')){
            $elements[] = $data;
        }

        $this->valueAttribute($elements, $default);

        return implode(' ', $elements);
    }
}

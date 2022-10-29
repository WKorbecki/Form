<?php

namespace WKorbecki\Form\Traits\Element;

trait SelectOptionTrait {
    protected final function options() : string {
        $options = [];

        foreach ($this->options as $key => $value){
            if (is_array($value)){
                $group_options = [];

                foreach ($value as $sub_key => $sub_value){
                    $group_options[] = $this->option($sub_key, $sub_value);
                }

                $options[] = '<optgroup label="' . $key . '">' . implode('', $group_options) . '</optgroup>';
            }
            else{
                $options[] = $this->option($key, $value);
            }
        }

        return implode('', $options);
    }

    protected final function option($key, $value) : string {
        $selected = is_array($this->value) ? in_array($key, $this->value) : ((string) $key === (string) $this->value);

        return '<option value="' . $key . '"'.($selected ? ' selected="selected"' : '') . '>' . $value . '</option>';
    }
}

<?php

namespace WKorbecki\Form\Traits\Element;

trait RadioOptionTrait {
    protected final function options($default = null) : string {
        $options = [];

        foreach ($this->options as $key => $value){
            if (!is_array($value)){
                $checked = is_array($this->value ?? $default) ? in_array($key, ($this->value ?? $default)) : ((string) $key === (string) ($this->value ?? $default));
                $option_id = $this->id . '-' . $key;
                $attributes = str_replace("id=\"{$this->id}\"", "id=\"{$option_id}\"", $this->attributes($default));
                $options[] = "<div class=\"form-check\">
                    <input type=\"radio\" {$attributes} value=\"{$key}\"" . ($checked ? (' checked=\"checked\"') : '') . ">
                    <label for=\"{$option_id}\" class=\"form-check-label\">{$value}</label>
                </div>";
            }
        }

        return implode("\n", $options);
    }
}

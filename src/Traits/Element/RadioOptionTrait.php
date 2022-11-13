<?php

namespace WKorbecki\Form\Traits\Element;

trait RadioOptionTrait {
    private ?string $option_id = null;

    protected final function options($default = null) : string {
        $options = [];

        foreach ($this->options as $key => $value){
            if (!is_array($value)){
                $options[] = $this->optionsByStyle($key, $value, $default);
            }
        }

        return implode("\n", $options);
    }

    private function optionsByStyle($key, $value, $default) : string {
        $attributes = $this->radioAttributes($key, $default);

        switch ($this->render) {
            case 'bootstrap4':
                $this->class = implode(' ', [...explode(' ', $this->class), 'custom-control-input']);
                return $this->optionsBootstrap4($key, $value, $attributes);
            case 'bootstrap5':
                $this->class = implode(' ', [...explode(' ', $this->class), 'form-check-input']);
                return $this->optionsBootstrap5($key, $value, $attributes);
        }

        return '';
    }

    private function optionsBootstrap4($key, $value, $attributes) : string {
        return implode("\n", [
            '<div class="custom-control custom-radio">',
            '<input type="radio" '.$attributes.'>',
            '<label for="'.$this->option_id.'" class="custom-control-label">'.$value.'</label>',
            '</div>'
        ]);
    }

    private function optionsBootstrap5($key, $value, $attributes) : string {
        return implode("\n", [
            '<div class="form-check">',
            '<input type="radio" '.$attributes.'>',
            '<label for="'.$this->option_id.'" class="form-check-label">'.$value.'</label>',
            '</div>'
        ]);
    }

    private function isChecked($key, $default = null) : bool {
        return is_array($this->value ?? $default) ? in_array($key, ($this->value ?? $default)) : ((string) $key === (string) ($this->value ?? $default));
    }

    private function radioAttributes($key, $default = null) : string {
        $this->option_id = $this->id . '-' . $key;

        if ($this->isChecked($key, $default)) {
            $this->attributes['checked'] = 'checked';
        }

        $this->attributes['value'] = $key;

        return str_replace("id=\"{$this->id}\"", "id=\"{$this->option_id}\"", $this->attributes($default));
    }
}

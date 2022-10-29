<?php

namespace WKorbecki\Form\Traits\Element;

trait RenderTrait {
    public function render($default = null) : string {
        return $this->custom_view_group ?
            view($this->custom_view_group, $this->toArray())->render() :
            implode("\n", [
                '<div class="form-group">',
                $this->renderLabel(),
                $this->renderInputGroup($default),
                $this->renderErrors(),
                '</div>',
            ]);
    }

    public function renderElement($default = null) : string {
        return $this->custom_view_element ?
            view($this->custom_view_element, ['value' => $default] + $this->toArray())->render() :
            '';
    }

    public function renderLabel() : string {
        return $this->custom_view_label ?
            view($this->custom_view_label, $this->toArray())->render() :
            ($this->label ? ('<label class="' . $this->label_class . '" for="' . $this->attributes['id'] . '">' . $this->label . '</label>') : '');
    }

    public function renderInputGroup($default = null) : string {
        $prepend = $this->renderInputGroupText($this->prepend);
        $append = $this->renderInputGroupText($this->append);

        $html = [
            $this->renderElement($default),
        ];

        if ($prepend || $append){
            $html = [
                '<div class="input-group">',
                $prepend ? ('<div class="input-group-prepend">' . $prepend . '</div>') : '',
                $this->renderElement($default),
                $append ? ('<div class="input-group-append">' . $append . '</div>') : '',
                '</div>',
            ];
        }

        return implode("\n", $html);
    }

    public function renderInputGroupText(array $items) : ?string {
        $html = [];

        foreach ($items as $item) {
            if ($item) {
                $html[] = implode("\n", [
                    '<span class="input-group-text">',
                    $item,
                    '</span>',
                ]);
            }
        }

        if (count($html) == 0) {
            return null;
        }

        return implode("\n", $html);
    }

    public function renderErrors() : string {
        $html = [];

        if ($this->valid == -1) {
            foreach ($this->errors as $i => $error) {
                $html[] = '<span id="error-' . $this->id . '-' . $i . '" class="error invalid-feedback d-block">' . $error . '</span>';
            }
        }

        return implode("\n", $html);
    }
}

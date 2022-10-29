<?php

namespace WKorbecki\Form;

use WKorbecki\Form\Traits\Form\ElementTrait;
use WKorbecki\Form\Traits\Form\PopulateTrait;
use WKorbecki\Form\Traits\Form\RenderTrait;
use WKorbecki\Form\Traits\Form\ValidatorTrait;
use Illuminate\Support\MessageBag;

abstract class Form {
    use ElementTrait;
    use PopulateTrait;
    use RenderTrait;
    use ValidatorTrait;

    /* @var $elements Element[] */
    private $elements = [];
    private ?MessageBag $errors = null;

    public function toArray() : array {
        $elements = [];

        foreach ($this->elements as $hash => $element){
            $elements[$hash] = $element->toArray();
        }

        return [
            'elements' => $elements,
            'errors' => $this->errors,
            'messages' => [],
        ];
    }

    public function values(?string $group = null) : array {
        $values = [];

        foreach ($this->elements as $element) {
            if (!$group || $element->isGroup($group)) {
                $values[$element->name()] = request()->isMethod('post') ? request($element->request_name()) : $element->value();
            }
        }

        return $values;
    }
}

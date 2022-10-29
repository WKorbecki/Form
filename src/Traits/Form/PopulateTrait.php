<?php

namespace WKorbecki\Form\Traits\Form;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait PopulateTrait {
    public function populate($obj){
        $obj = $this->mapObject($obj);

        foreach ($this->elements as $name => $element){
            $name_struct = explode('.', $name);
            $element_value = $element->value();

            if (isset($name_struct[1]) && ((is_array($element_value) && count($element_value) == 0) || is_null($element_value))){
                $obj_val = $obj;

                for ($i = 0; $i < count($name_struct); $i++){
                    $obj_val = $obj_val[$name_struct[$i]] ?? $element_value;
                }

                $element->populate($obj_val);
            }
            elseif (isset($obj[$name]) && ((is_array($element_value) && count($element_value) == 0) || is_null($element_value))){
                $element->populate($obj[$name]);
            }
        }
    }

    private function mapObject($obj) : array {
        if (is_object($obj)) {
            $array = $obj instanceof Model ? $obj->toArray() : (array) $obj;

            foreach ($array as $field => $value){
                if ($obj->{$field} instanceof Carbon){
                    $array[$field] = $obj->{$field}->format('Y-m-d H:i:s');
                }
            }

            $obj = $array;
            unset($array);
        }

        return $obj;
    }
}

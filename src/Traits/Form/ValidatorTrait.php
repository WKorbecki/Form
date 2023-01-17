<?php

namespace WKorbecki\Form\Traits\Form;

use WKorbecki\Form\Enum\ValidatorMethod;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait ValidatorTrait {
    public function validation(?string $validate_on = ValidatorMethod::Post, array $rules = [], array $messages = []) : bool {
        if ($this->checkMethod($validate_on)) {
            return false;
        }

        foreach ($this->elements as $element){
            $rules[$element->request_name()] = $this->rules2array($rules[$element->request_name()] ?? $element->rules());
            $messages[$element->request_name()] = $messages[$element->request_name()] ?? $element->messages();
            $element->populate(request($element->request_name()));
        }

        if (count($rules) > 0){
            $validation = Validator::make(request()->all(), $rules, $messages);

            foreach ($this->elements as $element){
                $element->setErrors($validation->errors()->messages()[$element->request_name()] ?? []);
            }

            if ($validation->fails()){
                $this->errors = $validation->errors();

                return false;
            }
        }

        return true;
    }

    public function validationGet(array $rules = [], array $messages = []) : bool {
        return $this->validation(ValidatorMethod::Get, $rules, $messages);
    }

    public function validationPost(array $rules = [], array $messages = []) : bool {
        return $this->validation(ValidatorMethod::Post, $rules, $messages);
    }

    public function validationPut(array $rules = [], array $messages = []) : bool {
        return $this->validation(ValidatorMethod::Put, $rules, $messages);
    }

    private function checkMethod(?string $validate_on) : bool {
        if ($validate_on === null) {
            return false;
        }

        $methods = [
            ValidatorMethod::Get,
            ValidatorMethod::Post,
            ValidatorMethod::Put,
        ];

        foreach ($methods as $method) {
            if (Str::lower($validate_on) === $method && !request()->isMethod($method)) {
                return true;
            }
        }

        return false;
    }

    private function rules2array($rules) : array {
        if (!is_array($rules)) {
            return explode('|', $rules);
        }

        return $rules;
    }
}

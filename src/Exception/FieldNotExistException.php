<?php

namespace WKorbecki\Form\Exception;

class FieldNotExistException extends \Exception {
    protected $message = 'Field not exist.';
    protected $code = 500;
}

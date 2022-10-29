<?php

namespace WKorbecki\Form\Exception;

class WrongTypeException extends \Exception {
    protected $message = 'Wrong form input type.';
    protected $code = 500;
}

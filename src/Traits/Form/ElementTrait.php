<?php

namespace WKorbecki\Form\Traits\Form;

use WKorbecki\Form\Element;
use WKorbecki\Form\Element\Checkbox;
use WKorbecki\Form\Element\Input;
use WKorbecki\Form\Element\Radio;
use WKorbecki\Form\Element\Select;
use WKorbecki\Form\Element\TextArea;
use WKorbecki\Form\Enum\ElementType;
use WKorbecki\Form\Exception\FieldNotExistException;
use WKorbecki\Form\Exception\WrongTypeException;

trait ElementTrait {
    /**
     * Add field element to form
     * @param string $name Field name
     * @param string $type Field type
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addField(string $name, string $type, array $data){
        $data['name'] = $name;

        switch ($type){
            case ElementType::Email:
            case ElementType::File:
            case ElementType::Hidden:
            case ElementType::Number:
            case ElementType::Password:
            case ElementType::Text: $this->addElement(new Input($name, $type, $data)); break;
            case ElementType::Checkbox: $this->addElement(new Checkbox($name, $data)); break;
            case ElementType::Radio: $this->addElement(new Radio($name, $data)); break;
            case ElementType::Select: $this->addElement(new Select($name, $data)); break;
            case ElementType::TextArea: $this->addElement(new TextArea($name, $data)); break;
            default: throw new WrongTypeException();
        }
    }

    /**
     * @param Element $element
     * @return void
     */
    public function addElement(Element $element) {
        $this->elements[$element->name()] = $element;
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldEmail(string $name, array $data) {
        $this->addField($name, ElementType::Email, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldFile(string $name, array $data) {
        $this->addField($name, ElementType::File, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldHidden(string $name, array $data) {
        $this->addField($name, ElementType::Hidden, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldNumber(string $name, array $data) {
        $this->addField($name, ElementType::Number, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldPassword(string $name, array $data) {
        $this->addField($name, ElementType::Password, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldText(string $name, array $data) {
        $this->addField($name, ElementType::Text, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldCheckbox(string $name, array $data) {
        $this->addField($name, ElementType::Checkbox, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldRadio(string $name, array $data) {
        $this->addField($name, ElementType::Radio, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldSelect(string $name, array $data) {
        $this->addField($name, ElementType::Select, $data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     * @throws WrongTypeException
     */
    public function addFieldTextArea(string $name, array $data) {
        $this->addField($name, ElementType::TextArea, $data);
    }

    /**
     * @param string $name
     * @return Element|null
     */
    public function getElement(string $name) : ?Element {
        return $this->elements[$name] ?? null;
    }

    /**
     * @param string $name
     * @param string $type
     * @param array $data
     * @return void
     * @throws FieldNotExistException
     * @throws WrongTypeException
     */
    public function modifyField(string $name, string $type, array $data){
        $element = $this->elements[$name] ?? null;

        if (!$element){
            throw new FieldNotExistException();
        }

        $this->addField($name, $type, $data);
    }

    /**
     * @param Element $element
     * @return void
     * @throws FieldNotExistException
     */
    public function modifyElement(Element $element) {
        if (!isset($this->elements[$element->name()])) {
            throw new FieldNotExistException();
        }

        $this->addElement($element);
    }
}

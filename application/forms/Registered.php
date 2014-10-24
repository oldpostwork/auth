<?php

/**
 * Registered forms
 */
class Application_Form_Registered extends Zend_Form
{
    /**
     * 
     */
    public function init()
    {
        $this->setName('registered_form');
        $this->setMethod('POST');
        $this->addElement(new Zend_Form_Element_Text('login', array(
            'label' => 'Логин',
            'required' => true,
            'validators' => array(
                'NotEmpty', 
                array(
                    'validator' => 'Db_NoRecordExists',
                    'options' => array('users', 'email'),
                )
            ),
            'filters' => array('StripTags', 'StringTrim')
        )));
        $this->addElement(new Zend_Form_Element_Password('password', array(
            'label' => 'Пароль',
            'required' => true,
        )));
        $this->addElement(new Zend_Form_Element_Text('name', array(
            'label' => 'Имя',
            'required' => true,
            'validators' => array('NotEmpty'),
            'filters' => array('StripTags', 'StringTrim')
        )));
        $this->addElement(new Zend_Form_Element_Text('email', array(
            'label' => 'Email',
            'required' => true,
            'validators' => array(
                'NotEmpty', 
                'EmailAddress',
                array(
                    'validator' => 'Db_NoRecordExists',
                    'options' => array('users', 'email'),
                )
            ),
            'filters' => array('StripTags', 'StringTrim')
        )));
        $this->addElement(new Zend_Form_Element_Submit('submit', array(
            'label' => 'Зарегистрироваться'
        )));
    }
}


<?php

class Application_Form_Post extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
                
        // add CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore'     => true,
            'salt'       => 'post_salt'
        ));
            
        // Add a title element
        $this->addElement('text', 'title', array(
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(0, 40))
            ),
        ));

        // Add a message element
        $this->addElement('textarea', 'body', array(
            'required'   => true,
            'rows'       => 1,
            'filters'    => array(
                'StringTrim',
                'StripTags',
                'HtmlEntities'
            ),
            'validators' => array(
                array('StringLength', true, array(1, 500,
                    'messages' => array(
                        'stringLengthTooLong' => 'Messages must be less than 500 characters'
                    )
                ))
            )
        ));

        // Add the submit button
        $this->addElement('button', 'submit', array(
            'ignore'     => true,
            'type'       => 'submit',
            'label'      => 'Post'
        ));
    }
}
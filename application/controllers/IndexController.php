<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $form = new Application_Form_Post();
        
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $post = new Application_Model_Post($form->getValues());
                $post->save();
                
                // reset the form
                $form->reset();
            }
        }
        
        // show all posts
        $posts = new Application_Model_Post();
        
        $this->view->form = $form;
        $this->view->posts = $posts->fetchAll();
    }
}
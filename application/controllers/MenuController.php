<?php

class MenuController extends Zend_Controller_Action
{

    public function afficherAction()
    {
        $this->_helper->viewRenderer->setResponseSegment('menu');
    }
    
}


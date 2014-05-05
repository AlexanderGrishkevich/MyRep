<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Post\Form\PostForm;

class IndexController extends AbstractActionController {
    public function indexAction() {
    	$postForm = new PostForm();
        return array('form' => $postForm);
    }
}


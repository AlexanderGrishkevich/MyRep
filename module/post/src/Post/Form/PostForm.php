<?php

namespace Post\Form;
use Zend\Form\Form;
use Zend\Form\Element;

class PostForm extends Form 
{
	public function __construct($name = null) {
		parent::__construct('Post');
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'post-add');
		$this->setAttribute('action', '/post/add');

 		$this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
        ));

		$this->add(array(
			'name' => 'title',
			'attributes' => array(
				'type' => 'text',
				'class' => 'form-control',
				'required' => 'required',
				'placeholder' => 'Post title',
			),
		));

		$this->add(array(
			'name' => 'text',
			'attributes' => array(
				'type' => 'textarea',
				'class' => 'form-control',
				'required' => 'required',
				'placeholder' => 'Post text',
			),
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Add post',
				'class' => 'btn btn-lg',
			),
		));
	}
}


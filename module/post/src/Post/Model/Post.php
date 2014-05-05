<?php
namespace Post\Model;

class Post {
	public $id;
	public $title;
	public $text;

	public function exchangeArray($data) {
		$this->id    = (!empty($data['id'])) ? $data['id'] : null;
		$this->title = (!empty($data['title'])) ? $data['title'] : null;
		$this->text  = (!empty($data['text'])) ? $data['text'] : null;
	}

	public function getArrayCopy() {
		return get_object_vars($this);
	}

}
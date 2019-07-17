<?php

class IndexController extends Yaf_Controller_Abstract {
	public function indexAction() {
		exit();
	}

	public function init() {
		Yaf_dispatcher::getInstance()->disableView();
	}
}

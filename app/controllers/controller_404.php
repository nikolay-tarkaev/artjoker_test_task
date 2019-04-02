<?php

class Controller404 extends Controller{

	function actionIndex(){
		$this->view->generate('404_view.php', $this->template);
	}

}

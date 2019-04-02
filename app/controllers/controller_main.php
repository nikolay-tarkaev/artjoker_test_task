<?php

class ControllerMain extends Controller{

	function __construct(){
	    $this->includeModel(array('t_koatuu_tree'));  // $this->model['t_koatuu_tree'];
	    $this->includeModel(array('tt_users'));       // $this->model['tt_users'];
		$this->view = new View();
	}

	public function actionIndex(){
	    $data['users'] = $this->model['tt_users']-> getAllUsers();
		$this->view->generate('main_view.php', $this->template, $data);
	}

	// Ajax запросы обрабатываются тут
	public function actionAjax(){
        if($_POST['getTerModal']){                    // Получить список областей/районов/городов
            $this->getTerModal($_POST);
        } elseif($_POST['checkEmailModal']){          // Проверка email на существование
            $this->checkEmailModal($_POST);
        } elseif($_POST['saveUserModal']){            // Сохранить данные
            $this->saveUserModal($_POST);
        } else{
            Route::errorPage404();
        }
    }

    protected function getTerModal($post){
        if(isset($post['ter_id']) and !empty($post['ter_id'])){
            $ter_id = htmlspecialchars(trim($post['ter_id']));
        } else{
            $ter_id = null;
        }

        echo json_encode($this->model['t_koatuu_tree']->getTerritory($ter_id));
    }

    protected function checkEmailModal($post){
        $email = htmlspecialchars(trim($post['checkEmailModal']));
        $get_email = $this->model['tt_users']->getEmail($email);
        if($get_email !== false){
            $result = array(
                'info' => 'find'
            );
            $result = array_merge($result, $get_email);
        } else{
            $result = array(
                'info' => 'empty'
            );
        }
        echo json_encode($result);
    }

    protected function saveUserModal($post){
        $name = htmlspecialchars(trim($post['name']));
        $email = htmlspecialchars(trim($post['email']));
        $territory = htmlspecialchars(trim($post['territory']));
        if(!empty($name) and !empty($email) and !empty($territory)){
            $full_address = $this->model['t_koatuu_tree']->getFullAddress($territory);
            if($full_address !== false){
                $result = $this->model['tt_users']->saveUser($name, $email, $full_address['ter_address']);
                if($result !== false){
                    $json_result = true;
                } else{
                    $json_result = false;
                }
            } else{
                $json_result = false;
            }
        } else{
            $json_result = false;
        }
        echo json_encode($json_result);
    }
}

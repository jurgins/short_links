<?php
    class Home extends Controller {

        public function index() {
            $data = [];

            $link = $this->model('LinkModel');

            if(isset($_POST['name'])) {
                $user = $this->model('UserModel');
                $user->setData($_POST['email'], $_POST['name'], $_POST['pass']);

                $isValid = $user->validForm();
                if($isValid == 'Верно') {
                    $user->addUser();
                    var_dump($_POST['email'], $_POST['name'], $_POST['pass']);
                } else {
                    $data['message'] = $isValid;
                }
            }

            if(isset($_POST['long_link'])) {
                $link->setData($_POST['long_link'], $_POST['short_link'], $_COOKIE['login']);

                $isValid = $link->validLinkForm();
                if($isValid == 'Верно') {
                    $link->addLink();
                } else {
                    $data['message'] = $isValid;
                }
            }

            if(isset($_POST['remove_link_id'])) {
                $link->deleteLink($_POST['remove_link_id']);
            }

            $data['links'] = $link->getLinks($_COOKIE['login']);

            $this->view('home/index', $data);
        }
    }
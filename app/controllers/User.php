<?php
class User extends Controller {

    public function index() {
        $data = [];
        $user = $this->model('UserModel');

        if(isset($_POST['exit_btn'])) {
            $user->logout();
            exit();
        }

        $data['user'] = $user->getUser();
        $this->view('user/index', $data);
    }

    public function auth() {
        $data = [];
        if(isset($_POST['email'])) {
            $user = $this->model('UserModel');
            $data['message'] = $user->auth($_POST['email'], $_POST['pass']);
        }
        $this->view('user/auth', $data);
    }
}

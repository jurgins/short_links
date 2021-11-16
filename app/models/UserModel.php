<?php
require "DB.php";

class UserModel {
    private $email;
    private $name;
    private $pass;

    private $db = null;

    public function __construct() {
        $this->db = DB::getInstence();
    }

    public function setData($email, $name, $pass) {
        $this->email = $email;
        $this->name = $name;
        $this->pass = $pass;
    }

    public function validForm() {
        if(strlen($this->email) < 3)
            return "Email слишком короткий";
        else if(strlen($this->name) < 3)
            return "Логин слишком короткий";
        else if(in_array($this->name, $this->getAllLogins()))
            return "Пользователь с таким логином уже существует";
        else if(strlen($this->pass) < 3)
            return "Пароль не менее 3 символов";
        else
            return "Верно";
    }

    public function addUser() {
        $sql = 'INSERT INTO users(name, email, pass) VALUES (:name, :email, :pass)';
        $query = $this->db->prepare($sql);
        $pass = password_hash($this->pass, PASSWORD_DEFAULT);
        $query->execute(['name' => $this->name, 'email' => $this->email, 'pass' => $pass]);

        $this->setAuth($this->email);
    }

    public function getUser() {
        $email = $_COOKIE['login'];
        $result = $this->db->query("SELECT * FROM `users` WHERE `email` = '$email'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllLogins() {
        $result = $this->db->query("SELECT `name` FROM `users`");
        return $result->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function logout() {
        setcookie('login', $this->email, time() - 3600, '/');
        unset($_COOKIE['login']);
        header('Location: /short_links/user/auth');
    }

    public function auth($email, $pass) {
        $result = $this->db->query("SELECT * FROM `users` WHERE `email` = '$email'");
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if($user['email'] == '') {
            return 'Пользователя с таким email не существует';
        } else if(password_verify($pass, $user['pass'])) {
            $this->setAuth($email);
        } else {
            return 'Пароли не совпадают';
        }
    }

    public function setAuth($email) {
        setcookie('login', $email, time() + 3600, '/');
        header('Location: /short_links/user');
    }

}

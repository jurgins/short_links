<?php
require 'DB.php';

class LinkModel {
    private $long_link;
    private $short_link;
    private $email_user;

    private $db = null;

    public function __construct() {
        $this->db = DB::getInstence();
    }

    public function setData($long_link, $short_link, $email_user) {
        $this->long_link = $long_link;
        $this->short_link = $short_link;
        $this->email_user = $email_user;
    }

    public function validLinkForm() {
        if(strlen($this->long_link) < 3)
            return "Длинная ссылка слишком короткая";
        else if(strlen($this->short_link) < 1)
            return "Введите короткое название";
        else if(in_array($this->short_link, $this->getAllShortLinks())) {
            return "Такое сокращение уже используется в базе";
        }
        else
            return "Верно";
    }

    public function addLink() {
        $sql = 'INSERT INTO links(long_link, short_link, email_user) VALUES (:long_link, :short_link, :email_user)';
        $query = $this->db->prepare($sql);
        $query->execute(['long_link' => $this->long_link, 'short_link' => $this->short_link, 'email_user' => $this->email_user]);
    }

    public function getLinks($email) {
        $result = $this->db->query("SELECT * FROM `links` WHERE `email_user` = '$email'");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllShortLinks() {
        $result = $this->db->query("SELECT `short_link` FROM `links` WHERE `email_user` = '$this->email_user'");
        return $result->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function deleteLink($id) {
        $sql = 'DELETE FROM `links` WHERE `id` = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
    }
}
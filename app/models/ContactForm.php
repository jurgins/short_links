<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

    class ContactForm {
        private $name;
        private $email;
        private $age;
        private $message;

        public function setData($name, $email, $age, $message) {
            $this->name = $name;
            $this->email = $email;
            $this->age = $age;
            $this->message = $message;
        }

        public function validForm() {
            if(strlen($this->name) < 3)
                return "Имя слишком короткое";
            else if(strlen($this->email) < 3)
                return "Email слишком короткий";
            else if(!is_numeric($this->age) || $this->age <= 0 || $this->age > 90)
                return "Вы ввели не возраст";
            else if(strlen($this->message) < 5)
                return "Сообщение слишком короткое";
            else
                return "Верно";
        }

        public function mail() {
            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->isSMTP();
            $mail->Host   = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'login@gmail.com';
            $mail->Password   = 'password';
            $mail->SMTPSecure = 'ssl';
            $mail->Port   = 465;

            $mail->setFrom('login@gmail.com', 'Elena');
            $mail->addAddress("$this->email", "$this->name");

            $mail->Subject = "$this->message";
            $mail->msgHTML("<html><body>
                <p>Имя: $this->name</p>
                <p>Возраст: $this->age</p>
                <p>Сообщение: $this->message</p>
                </html></body>");

            if($mail->send()) {
                return 'Сообщение отправленно!';
            } else {
                return $mail->ErrorInfo;
            }
        }
    }
<?php
require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
class Model_Register extends Model{
    private $login, $name, $surname, $birthday,$city, $email, $pass, $pass_again;
    private $error, $mail;
    function __construct()
    {
        parent::__construct();
        $this->mail = new PHPMailer();
    }

    function setInfo($login, $name, $surname, $birthday,$city, $email, $pass, $pass_again){
        //var_dump($login);
        $this->login = $login;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->city = $city;
        $this->email = $email;
        $this->pass = $pass;
        $this->pass_again = $pass_again;
    }

    function getError(){
        return $this->error;
    }

    function insert(){
        $mass = [
            'name' => $this->name,
            'surname' => $this->surname,
            'birthday' => $this->birthday,
            'city' => $this->city,
            'email' => $this->email,
            'hash' => '',
        ];
        //$query = "insert into users(name, surname, birthday, city, email, hash, avatar) values('$this->name', '$this->surname', '$this->birthday','$this->city', '$this->email', '', '')";
        $this->pdo->insert('users', $mass);
        //$query = "select id from Users ORDER BY id DESC LIMIT 1";
        //$res = $this->pdo->query($query)->fetchAll();
        $res = $this->pdo->selectLastElement('users', 'id');
        $id_user = $res[0]['id'];
        //$pass = password_hash($this->pass, PASSWORD_BCRYPT);
        $mass = [
            'login' => $this->login,
            'pass' => $this->pass,
            'fk_user' => $id_user
        ];
        //$query = "insert into account(login, pass, fk_user) values('$this->login', '$pass', '$id_user')";
        $this->pdo->insert('account', $mass);
        //$this->pdo->query($query);
        $this->sendHash();
    }

    function insert_hash($id, $hash){
        $mass = [
            'hash' => $hash
        ];
        $this->pdo->update('users', $mass, 'id', $id);
        $this->sendHash();
    }

     function ValidForm(){
        $pattern_for_name = '/[А-Яа-я]+/';
        $pattern_for_email = '/[A-Za-z0-9]{1,}@[A-Za-z]{1,6}.[a-z]{1,4}/';
        if(preg_match($pattern_for_name, $this->name) == 0){
            $this->error = 'name';
            return false;
        }
        elseif(preg_match($pattern_for_name, $this->surname) == 0){
            $this->error = 'surname';
            return false;
        }
        elseif($this->pass != $this->pass_again){
            $this->error = 'pass';
            return false;
        }
        return true;
    }

    function checkUsers(){
        $query = "select*from users where email='$this->email'";
        $res = $this->pdo->select('users', 'email', $this->email);
        if(count($res) > 0){
            $this->error = 'Такой пользователь уже существует';
            return false;
        }
        return true;
    }

    function checkLogin(){
        $query = "select*from account where login='$this->login'";
        $res = $this->pdo->select('account', 'login', $this->login);
        if(count($res) > 0){
            $this->error = 'Такой логин существует';
            return false;
        }
        return true;
    }

    function pushHash($hash, $email){
        $query = "update users set hash='$hash' where email='$email'";
        $this->pdo->query($query);
    }

    private function generateHash(){
        $hash = md5(uniqid(rand(), true));
        return $hash;
    }

    private function sendHash(){
        $this->mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $this->mail->SMTPDebug = 0; // ДОЛЖЕН бЫТЬ 0
//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $this->mail->Host = 'smtp.gmail.com';
// use
        $this->mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = 465;
//Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = "myzykov1@gmail.com";
//Password to use for SMTP authentication
        $this->mail->Password = "pcgsrdvd";
//Set who the message is to be sent from
        $this->mail->setFrom('myzykov1@gmail.com', 'First Last');
//Set an alternative reply-to address
        $this->mail->addReplyTo('myzyv1@gmail.com', 'First Last');
//Set who the message is to be sent to
        $this->mail->addAddress($this->email, 'John Doe');
//Set the subject line
        $this->mail->Subject = 'Подтверждение реестрации';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $hash = $this->generateHash();
        $htmlBody = "Для подтверждения перейдите по ссилке:<br/>";
        $email = base64_encode($this->email);
        $htmlBody .= "http://autostop/register/hash/$hash/$email";
        //$this->mail->msgHTML($htmlBody, dirname(__FILE__));
        $this->mail->Body = $htmlBody;
        $this->mail->isHTML(true);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$this->mail->send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }

    }

}
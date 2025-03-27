<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/userDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);
$userDao = new userDAO($conn, $BASE_URL);

//resgata tipo de formulario
$type = filter_input(INPUT_POST,"type");

//verifica o tipo de formulario

if($type == 'register'){

    $name = filter_input(INPUT_POST,"name");
    $lastname = filter_input(INPUT_POST,"lastname");
    $email = filter_input(INPUT_POST,"email");
    $password = filter_input(INPUT_POST,"password");
    $confirmpassword = filter_input(INPUT_POST,"confirmpassword");

    //verificação de dados minimos
    if($name && $lastname && $email && $password){
        
        if($password === $confirmpassword){

            if($userDao->findByEmail($email) === false){

                $user = new User();

                //criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user,$auth);

            }else{
                $message->setMessage("Email já cadastrado.", "msg-error","back");
            }

        }else{  
            $message->setMessage("As senhas não são iguais.", "msg-error","back");
        }

    }else{
        $message->setMessage("por favor, preencha todos os campos.", "msg-error","back");
    }
    

}else if($type == 'login'){
    $email = filter_input(INPUT_POST,"email");
    $password = filter_input(INPUT_POST,"password");

    //tenta autenticar usuario

    if($userDao->authenticateUser($email, $password)){

        $message->setMessage("Seja bem vindo. ", "msg-success","editprofile.php");

    }else{
        $message->setMessage("Usuario ou senha incorretos", "msg-error","back");
    }

    else{
        $message->setMessage("informações invalidas", "msg-error","index.php");
    }
}
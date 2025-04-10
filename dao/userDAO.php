<?php

include_once("models/User.php");
include_once("models/Message.php");

class userDAO implements userDAOInterface{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url){
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function builderUser($data){

        $user = new User();

        $user->id = $data["id"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->image = $data["image"];
        $user->bio = $data["bio"];
        $user->token = $data["token"];

        return $user;
    }

    public function create(User $user, $authUser = false){

        $stmt = $this->conn->prepare("INSERT INTO users(
            name, lastname, email, password, token
        )VALUES (
            :name, :lastname, :email, :password, :token
        )");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        //authenticar usuario

        if($authUser){
            $this->setTokenToSession($user->token);
        }
    }

    public function update (User $user, $redirect = true){

        $stmt = $this->conn->prepare("UPDATE users SET 
            name = :name,
            lastname = :lastname,
            email = :email,
            image = :image,
            bio = :bio,
            token = :token
            WHERE id = :id
        ");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        if($redirect){
            $this->message->setMessage("Dados atualizados com sucesso!","msg-success", "editprofile.php");
        }

    }

    public function verifyToken($protected = false) {
        if (!empty($_SESSION["token"])) {
            // Pega o token da sessão
            $token = $_SESSION["token"];
    
            $user = $this->findByToken($token);
    
            if ($user) {
                return $user;
            } else {
                if ($protected) {
                    $this->message->setMessage("Faça a autenticação para acessar esta página", "msg-error", "index.php");
                    exit; // Garante que o código pare a execução após o redirecionamento
                }
            }
        } else {
            if ($protected) {
                $this->message->setMessage("Faça a autenticação para acessar esta página", "msg-error", "index.php");
                exit;
            }
            return false;
        }
    }

    public function setTokenToSession($token, $redirect = true){
        //salvar token na seção

        $_SESSION["token"] = $token;

        if($redirect){
            $this->message->setMessage("seja bem vindo!","msg-success", "editprofile.php");
        }
    }

    public function authenticateUser($email, $password){

        $user = $this->findByEmail($email);


        if($user){
            if(password_verify($password, $user->password)){

                //gerar um token e inserir na session

                $token = $user->generateToken();

                $this->setTokenToSession($token, false);

                //atualizar token do usuario.
                $user->token = $token;

                $this->update($user, false);

                return true;
            }else{
                return false;
            }
        }else{

        }
    }

    public function findByEmail($email){
        
        if($email != ""){

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email",$email);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetch();
                $user = $this->builderUser($data);

                return $user;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function findById($id){
        if($id != ""){

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetch();
                $user = $this->builderUser($data);

                return $user;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function findByToken($token){
        if($token != ""){

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
            $stmt->bindParam(":token",$token);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                $data = $stmt->fetch();
                $user = $this->builderUser($data);

                return $user;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function destroyToken(){

        $_SESSION["token"] = "";
        $this->message->setMessage("você foi deslogado","msg-success", "index.php");

    }

    public function changePassword(User $user){

        $stmt = $this->conn->prepare("UPDATE users SET 
        password = :password WHERE id = :id
        ");

        $stmt->bindParam(":password" , $user->password);
        $stmt->bindParam(":id" , $user->id);

        $stmt->execute();
        $this->message->setMessage("Seenha alterado com sucesso","msg-success", "editprofile.php");
    }
}
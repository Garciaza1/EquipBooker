<?php

namespace EquipReservs\Models;

use EquipReservs\System\Database;

use PDO;
use Throwable;

class Main extends Database
{


    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    public function cadastrar_usuario($post_data)
    {
        $nome = $post_data['text_name'];
        $email = $post_data['text_email'];
        $senha = $post_data['text_senha'];


        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, ) VALUES (:nome, :email, :senha,)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }

    public function verificar_login($email, $senha)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);


        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($senha == $usuario['senha']) {
            //se stiver mais de zero rows ele da status true
            return [
                'status' => true
            ];
        } else {

            return [
                'status' => false
            ];
        }
    }

    public function get_user_data($email)
    {

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $data = [$usuario];

        return $data;
    }

    public function check_if_user_exists($post_data)
    {

        $user_email = $post_data['text_email'];

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $user_email);

        $stmt->execute();

        $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) { //se stiver mais de zero rows ele da status true
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }




    // UPDATES

    public function change_name($post_data)
    {
        $nome = $post_data['text_mudar_nome'];
        $id = $_SESSION['user']['id'];

        $stmt = $this->conn->prepare("UPDATE usuarios SET  nome = :nome UpdatedAt = NOW() WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id);;

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }

    public function change_email($post_data)
    {
        $email = $post_data['text_email_novo'];
        $id = $_SESSION['user']['id'];

        $stmt = $this->conn->prepare("UPDATE usuarios SET  email = :email UpdatedAt = NOW() WHERE id = :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);;

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }

    public function change_senha($post_data)
    {
        $senha = $post_data['text_senha_nova'];
        $id = $_SESSION['user']['id'];

        // $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE usuarios SET  senha = :senha UpdatedAt = NOW() WHERE id = :id");
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':id', $id);;

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }
}

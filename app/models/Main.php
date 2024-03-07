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

}
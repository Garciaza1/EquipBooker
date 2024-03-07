<?php

namespace EquipReservs\Models;

use EquipReservs\System\Database;
use PDO;
use Throwable;

class UserModel extends Database
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function reservar_equipamentos($data_inicio, $data_fim, $sala, $equipamento)
    {

        // declaração das variaveis do professor que está usando
        $id_professor = $_SESSION['user']['id'];
        $professor = $_SESSION['user']['nome'];

        // inicio do processo de insert
        $stmt = $this->conn->prepare("INSERT INTO reservas (data_inicio, data_fim, sala, equipamento, id_professor, professor)
         VALUES (:data_inicio, :data_fim, :sala, :equipamento, :id_professor, :professor)");

        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);
        $stmt->bindParam(':sala', $sala);
        $stmt->bindParam(':equipamento', $equipamento);
        $stmt->bindParam(':id_professor', $id_professor);
        $stmt->bindParam(':professor', $professor);

        try {
            $stmt->execute();
            return [
                'status' => true,
                'message' => "Reserva bem sucedida, das " . $data_inicio . " à " . $data_fim
            ];
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
            return [
                'status' => false,
                'message' => "Erro ao tentar executar a reserva" . $stmt . $e
            ];
        }
    }

    public function check_if_is_valid_date($inicio, $fim, $sala)
    {


        // Início do processo de select para verificar a disponibilidade da sala
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM reservas 
        WHERE sala = :sala 
        AND :inicio BETWEEN data_inicio AND data_fim 
        OR ( :fim BETWEEN data_inicio AND data_fim )");
        // a logica é a seguinte
        // se a data que foi enviada estiver entre o inicio e o fim da que está na tabela ele retorna o numero de evidencias encontradas

        $stmt->bindParam(':sala', $sala);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fim', $fim);

        try {

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {

                $response = [
                    'status' => "sala ocupada",
                    'message' => $result
                ];

                return $response;
            } else {

                $response = [
                    'status' => "sala livre",
                ];

                return $response;
            }
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }

    public function check_if_is_valid_date_edit($inicio, $fim, $sala, $id)
    {


        // Início do processo de select para verificar a disponibilidade da sala
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM reservas 
        WHERE sala = :sala AND id != :id
        AND (:inicio BETWEEN data_inicio AND data_fim 
        OR :fim BETWEEN data_inicio AND data_fim)");
        // a logica é a seguinte
        // se a data que foi enviada estiver entre o inicio e o fim da que está na tabela ele retorna o numero de evidencias encontradas

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sala', $sala);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fim', $fim);

        try {

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {

                $response = [
                    'status' => "sala ocupada",
                    'message' => $result
                ];

                return $response;
            } else {

                $response = [
                    'status' => "sala livre",
                ];

                return $response;
            }
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }



    public function get_all()
    {

        $stmt = $this->conn->prepare("SELECT * FROM reservas WHERE DeletedAt is null;");

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }






    //pega todos os dados não deletados
    public function get_user_reserva($UserId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reservas WHERE id_professor = :UserId AND DeletedAt is null");
        $stmt->bindParam(':UserId', $UserId);

        try {
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }

    public function delete_reserv($id)
    {
        $stmt = $this->conn->prepare("UPDATE reservas SET DeletedAt = Now() WHERE id = :id");
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }
    }


    // para fazer o edit 
    public function get_1_reserv($id)
    {

        $stmt = $this->conn->prepare("SELECT * FROM reservas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
        }

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user_data;
    }

    //UPDATES
    public function reserv_edit($data_inicio, $data_fim, $sala, $equipamento, $id)
    {
        // declaração das variaveis do professor que está usando
        $id_professor = $_SESSION['user']['id'];
        $professor = $_SESSION['user']['nome'];

        $stmt = $this->conn->prepare("UPDATE reservas 
        SET 
            data_inicio = :data_inicio, 
            data_fim = :data_fim, 
            sala = :sala, 
            equipamento = :equipamento, 
            id_professor = :id_professor, 
            professor = :professor 
        WHERE 
            id = :id");

        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);
        $stmt->bindParam(':sala', $sala);
        $stmt->bindParam(':equipamento', $equipamento);
        $stmt->bindParam(':id_professor', $id_professor);
        $stmt->bindParam(':professor', $professor);
        $stmt->bindParam(':id', $id);;

        try {
            $stmt->execute();
            return [
                'status' => true,
                'message' => "Reserva bem sucedida, das " . $data_inicio . " à " . $data_fim
            ];
        } catch (Throwable $e) {
            echo '<pre>';
            print_r($stmt);
            echo '<br>';
            print_r($e);
            return [
                'status' => false,
                'message' => "Erro ao tentar executar a reserva" . $stmt . $e
            ];
        }
    }

}

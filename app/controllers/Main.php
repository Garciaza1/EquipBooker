<?php

namespace EquipReservs\Controllers;

use EquipReservs\Controllers\BaseController;
use EquipReservs\Models\Main as ModelsMain;
use EquipReservs\Models\UserModel;

class Main extends BaseController
{

    public function home() //PUBLICO
    {

        // check if there is no active user in session and blocks if hasn't
        if (check_session()) {
            $data['user'] = $_SESSION['user'];
        } else {
            $data = [];
        }



        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('home_page');
        $this->view('shared/html_footer');
    }

    // =======================================================     
    public function acesso_negado()
    {

        if (isset($_SESSION['erro'])) $data['erro'] = $_SESSION['erro'];
        $data['request'] = $_REQUEST;
        $data['session'] = $_SESSION;
        $data['cookie'] = $_COOKIE;
        $data['get'] = $_GET;

        $this->view('shared/html_header');
        $this->view('acesso_negado', $data);
        $this->view('shared/html_footer');
    }

    // ======================================================= 
    public function index()
    {
        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        $data['user'] = $_SESSION['user'];



        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('home', $data);
        $this->view('shared/html_footer');
    }

    // ======================================================= 
    public function login()
    {
        // check if there is already a user in the session
        if (check_session()) {
            $this->index();
            return;
        }

        // check if there are errors (after login_submit)
        $data = [];
        if (!empty($_SESSION['validation_errors'])) {
            $data['validation_errors'] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }

        // check if there was an invalid login
        if (!empty($_SESSION['server_error'])) {
            $data['server_error'] = $_SESSION['server_error'];
            unset($_SESSION['server_error']);
        }

        // display login form
        $this->view('shared/html_header');
        $this->view('login', $data);
        $this->view('shared/html_footer');
    }

    // ======================================================= 
    public function login_submit()
    {

        // check if there is already an active session
        if (check_session()) {
            $this->index();
            return;
        }

        // check if there was a post request
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // form validation
        $validation_errors = [];
        if (empty($_POST['text_email']) || empty($_POST['text_password'])) {
            $validation_errors[] = "Email e password são obrigatórios.";
        }

        // get form data
        $email = $_POST['text_email'];
        $password = $_POST['text_password'];

        // check if username is valid email and between 5 and 50 chars
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validation_errors[] = 'O email tem que ser válido.';
        }

        // check if username is between 5 and 50 chars
        if (strlen($email) < 5 || strlen($email) > 50) {
            $validation_errors[] = 'O email deve ter entre 5 e 50 caracteres.';
        }

        // check if password is valid
        if (strlen($password) < 6 || strlen($password) > 12) {
            $validation_errors[] = 'A password deve ter entre 6 e 12 caracteres.';
        }


        // check if there are validation errors and return 
        if (!empty($validation_errors)) {
            $_SESSION['validation_errors'] = $validation_errors;
            $this->login();
            return;
        }

        //instancia o model
        $model = new ModelsMain();
        $result = $model->verificar_login($email, $password);

        //LOGIN VALIDO 
        if ($result['status']) {

            //load user information to the session
            $results = $model->get_user_data($email);
            // add user to session
            if (!empty($results)) {
                $_SESSION['user'] = $results[0]; // Armazena todos os resultados na sessão 'user'
            }
            // go to main page
            $this->index();
        }

        //login invalido
        else {

            $_SESSION['server_error'] = 'Login inválido. ';
            $this->login();
            return;
        }
    }

    // ======================   C A D A S T R O  =============================



    // // ======================================================= 
    // public function cadastro()
    // {
    //     // check if there is already a user in the session
    //     if (check_session()) {
    //         $this->index();
    //         return;
    //     }
    //     // check if there are errors
    //     $data = [];

    //     if (!empty($_SESSION['validation_errors'])) {
    //         $data['validation_errors'] = $_SESSION['validation_errors'];
    //         unset($_SESSION['validation_errors']);
    //     }

    //     // check if there was an invalid login
    //     if (!empty($_SESSION['server_error'])) {
    //         $data['server_error'] = $_SESSION['server_error'];
    //         unset($_SESSION['server_error']);
    //     }

    //     // display login form
    //     $this->view('shared/html_header', $data);
    //     $this->view('cadastro', $data);
    //     $this->view('shared/html_footer');
    // }


    // // resolver oque fazer com o cadastro.
    // // ======================================================= 
    // public function cadastro_submit()
    // {

    //     if (check_session() || $_SERVER['REQUEST_METHOD'] != 'POST') {
    //         $this->index();
    //         return;
    //     }

    //     // form validation
    //     $validation_errors = [];

    //     // text_name
    //     if (empty($_POST['text_name'])) {
    //         $validation_errors[] = "Nome é de preenchimento obrigatório.";
    //     } else {
    //         if (strlen($_POST['text_name']) < 3 || strlen($_POST['text_name']) > 50) {
    //             $validation_errors[] = "O nome deve ter entre 3 e 50 caracteres.";
    //         }
    //     }

    //     // senha
    //     if (empty($_POST['text_senha'])) {
    //         $validation_errors[] = "senha é de preenchimento obrigatório.";
    //     }


    //     // email
    //     if (empty($_POST['text_email'])) {
    //         $validation_errors[] = "Email é de preenchimento obrigatório.";
    //     } else {
    //         if (!filter_var($_POST['text_email'], FILTER_VALIDATE_EMAIL)) {
    //             $validation_errors[] = "Email não é válido.";
    //         }
    //     }


    //     // check if there are validation errors to return to the form
    //     if (!empty($validation_errors)) {
    //         $_SESSION['validation_errors'] = $validation_errors;
    //         $this->cadastro();
    //         return;
    //     }


    //     // check if the client already exists with the same name
    //     $model = new ModelsMain();
    //     $results = $model->check_if_user_exists($_POST);

    //     if ($results['status']) {

    //         // a person with the same name exists for this agent. Returns a server error
    //         $_SESSION['server_error'] = "Já existe um cliente com este email.";
    //         $this->cadastro();
    //         return;
    //     } else {

    //         // add new client to the database
    //         $model->cadastrar_usuario($_POST);

    //         // return to the main clients page
    //         $this->login();
    //     }
    // }


    // ======================================================= 

    public function logout()
    {

        $_SESSION['user'] = null;
        session_destroy();

        // go to main page
        $this->index();
        exit();
    }

    // ======================================================= 

    public function nova_reserva() //aponta para o nova_reserva_submit
    {

        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        $data = [];

        // check if there are errors

        if (!empty($_SESSION['validation_errors'])) {
            $data['validation_errors'] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }

        // check if there was an invalid login
        if (!empty($_SESSION['server_error'])) {
            $data['server_error'] = $_SESSION['server_error'];
            unset($_SESSION['server_error']);
        }

        $data['user'] = $_SESSION['user'];

        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('nova_reserva', $data);
        $this->view('shared/html_footer');
    }



    public function nova_reserva_submit() //aponta para o reserva_submit
    {

        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        // check if there was a post request
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // form validation
        $validation_errors = [];

        if (empty($_POST['text_inicio']) || empty($_POST['text_fim'])) {
            $validation_errors[] = "Ambas as datas precisam ser preenchidas";
        }

        if (empty($_POST['sala'])) {
            $validation_errors[] = "É preciso selecionar uma das salas";
        }

        // get form data
        $data_inicio = $_POST['text_inicio'];
        $data_fim = $_POST['text_fim'];
        $sala = $_POST['sala'];

        //define o equipamento usado
        switch ($sala) {
            case "Sala 1 (Televisão, Kit multimídia)":
                $equipamento = "Televisão, Kit multimídia";
                break;

            case 'Sala 2 (Datashow, Kit multimídia)':
                $equipamento = "Datashow, Kit multimídia";
                break;

            case "Sala 3 (Televisão com DVD)":
                $equipamento = "Televisão com DVD";
                break;

            case "Sala 4 (Televisão com VCR)":
                $equipamento = "Televisão com VCR";
                break;

            case "Sala 5 (Projetor, Kit multimídia)":
                $equipamento = "Projetor, Kit multimídia";
                break;

            case "Sala 6 (Sistemas de áudio com amplificador e microfone)":
                $equipamento = "Sistemas de áudio com amplificador e microfone";
                break;

            case "Sala 7 (Informática & Notebooks)":
                $equipamento = "Informática & Notebooks";
                break;

            case "Capela (Kit multimídia e instrumentos)":
                $equipamento = "Kit multimídia e instrumentos";
                break;

            default:
                $equipamento = "";
                break;
        }

        //instancia o model
        $model = new UserModel();

        //valida se existe ou não uma reserva da sala no horario.
        $result = $model->check_if_is_valid_date($data_inicio, $data_fim, $sala);

        if ($result['status'] == "sala ocupada") {
            $validation_errors[] = $sala . " ocupada entre: " . $data_inicio . " e " . $data_fim;
        }

        // check if there are validation errors and return 
        if (!empty($validation_errors)) {
            $_SESSION['validation_errors'] = $validation_errors;
            $this->nova_reserva();
            return;
        }

        if ($result['status'] == "sala livre") {
            $result = $model->reservar_equipamentos($data_inicio, $data_fim, $sala, $equipamento);
            $this->suas_reservas();
            return;
        }
    }

    // ======================================================= 

    public function reservas_table()
    {

        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        $data = [];

        $model = new UserModel;
        $result = $model->get_all();

        $data['user'] = $_SESSION['user'];
        $data['reservas'] = $result;

        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('reservas_table', $data);
        $this->view('shared/html_footer');
    }

    // ======================================================= 

    public function suas_reservas()
    {

        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        $data = [];

        $id = $_SESSION['user']['id'];
        $model = new UserModel;
        $result = $model->get_user_reserva($id);

        $data['user'] = $_SESSION['user'];
        $data['reservas'] = $result;


        if (!empty($_SESSION['erro'])) {
            $data['validation_errors'] = $_SESSION['erro'];
            unset($_SESSION['erro']);
        }

        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('suas_reservas', $data);
        $this->view('shared/html_footer');
    }

    // edits de reserva

    // ======================================================= 

    public function reserva_delete($id)
    {

        // Verifique se o ID foi passado
        if (!isset($_GET['id'])) {
            $_SESSION['erro'] = "Erro no Id passado!";
            $this->suas_reservas();
            return;
        }

        $id = $_GET['id'];

        $model = new UserModel();
        $model->delete_reserv($id);

        $this->suas_reservas();
        return;
    }

    public function reserva_edit($id)
    {
        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        $data = [];
        $model = new UserModel;
        $result = $model->get_1_reserv($id);

        // check if there are errors
        if (!empty($_SESSION['validation_errors'])) {
            $data['validation_errors'] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }

        // check if there was an invalid login
        if (!empty($_SESSION['server_error'])) {
            $data['server_error'] = $_SESSION['server_error'];
            unset($_SESSION['server_error']);
        }

        $data['user'] = $_SESSION['user'];
        $data['reserva'] = $result;

        $this->view('shared/html_header');
        $this->view('navbar', $data);
        $this->view('reserva_edit', $data);
        $this->view('shared/html_footer');
    }

    public function reserva_edit_submit($id)
    {
        // check if there is no active user in session and blocks if hasn't
        if (!check_session()) {
            $this->login();
            return;
        }

        // check if there was a post request
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // form validation
        $validation_errors = [];

        if (empty($_POST['text_inicio']) || empty($_POST['text_fim'])) {
            $validation_errors[] = "Ambas as datas precisam ser preenchidas";
        }

        if (empty($_POST['sala'])) {
            $validation_errors[] = "É preciso selecionar uma das salas";
        }

        // get form data
        $data_inicio = $_POST['text_inicio'];
        $data_fim = $_POST['text_fim'];
        $sala = $_POST['sala'];
        $id = $_POST['id'];

        //define o equipamento usado
        switch ($sala) {
            case "Sala 1 (Televisão, Kit multimídia)":
                $equipamento = "Televisão, Kit multimídia";
                break;

            case 'Sala 2 (Datashow, Kit multimídia)':
                $equipamento = "Datashow, Kit multimídia";
                break;

            case "Sala 3 (Televisão com DVD)":
                $equipamento = "Televisão com DVD";
                break;

            case "Sala 4 (Televisão com VCR)":
                $equipamento = "Televisão com VCR";
                break;

            case "Sala 5 (Projetor, Kit multimídia)":
                $equipamento = "Projetor, Kit multimídia";
                break;

            case "Sala 6 (Sistemas de áudio com amplificador e microfone)":
                $equipamento = "Sistemas de áudio com amplificador e microfone";
                break;

            case "Sala 7 (Informática & Notebooks)":
                $equipamento = "Informática & Notebooks";
                break;

            case "Capela (Kit multimídia e instrumentos)":
                $equipamento = "Kit multimídia e instrumentos";
                break;

            default:
                $equipamento = "";
                break;
        }

        //instancia o model
        $model = new UserModel();

        //valida se existe ou não uma reserva da sala no horario.
        $result = $model->check_if_is_valid_date_edit($data_inicio, $data_fim, $sala, $id);
        if ($result['status'] == "sala ocupada") {
            $validation_errors[] = $sala . " ocupada entre: " . $data_inicio . " e " . $data_fim;
        }

        // check if there are validation errors and return 
        if (!empty($validation_errors)) {
            $_SESSION['validation_errors'] = $validation_errors;
            $this->reserva_edit($id);
            return;
        }

        if ($result['status'] == "sala livre") {
            $result = $model->reserv_edit($data_inicio, $data_fim, $sala, $equipamento, $id);
            $this->suas_reservas();
            return;
        }
    
    
    }
}

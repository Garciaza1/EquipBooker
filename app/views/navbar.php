<?php

$logado = false;

if (check_session()) {

    $logado = true;

    $_SESSION['user'] = $data['user'];

    $nome = $data['user']['nome'];
    $partesDoNome = explode(" ", $nome);
    $primeiro_nome = $partesDoNome[0];

    $email = $data['user']['email'];
    $user_id = $data['user']['id'];
}
?>

<div class="container-fluid bng-navbar">
    <div class="row">

        <?php if ($logado) : ?>
            <div class="col-4 d-flex align-content-center p-3">
                <a href="?ct=main&mt=index"><img src="<?= IMAGE_PATH . 'logao.png' ?>" alt="logo EquipReservs" height="46" class="me-3"></a>
                <a href="?ct=main&mt=index" style="text-decoration: none; color:black;">
                    <h3><?= APP_NAME ?></h3>
                </a>
            </div>
        <?php else : ?>
            <div class="col-4 d-flex align-content-center p-3">
                <a href="?ct=main&mt=home"><img src="<?= IMAGE_PATH . 'logao.png' ?>" alt="logo EquipReservs" height="46" class="me-3"></a>
                <a href="?ct=main&mt=home" style="text-decoration: none; color:black;">
                    <h3><?= APP_NAME ?></h3>
                </a>
            </div>
        <?php endif; ?>

        <div class="text-center col-4 pt-4">
            <?php if ($logado) : ?>
                <h2>Bem-vindo! <span style=" font-style: italic;"><?= get_active_user_name(); // trocar por $primeiro nome caso necessario ?></span></h2>
            <?php endif; ?>
        </div>

        <?php if ($logado) : ?>
            <div class="col-4 text-end pe-4 pt-4">

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle pe-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 20%;">
                        <i class="fa-regular fa-user me-4"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?ct=main&mt=logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair</a></li>
                        <!-- <li><a class="dropdown-item" href="?ct=main&mt=cadastro"><i class="fa-solid fa-address-card me-2"></i>Cadastrar Professor</a></li> -->
                    </ul>
                </div>

            <?php else : ?>

                <div class="text-end col-4 mt-2 ">
                    <a href="?ct=main&mt=login" style="text-decoration: none; color: white;">
                        <button class="btn btn-dark m-2" type="button">
                            <i class="fa-solid fa-medal me-2"></i>
                            Entrar
                        </button>
                    </a>
                    <a href="?ct=main&mt=cadastro" style="text-decoration: none; color: white;">
                        <button class="btn btn-dark m-2" type="button">
                            <i class="fa-solid fa-person-skiing me-2"></i>
                            Cadastrar
                        </button>
                    </a>
                </div>
            <?php endif; ?>
            </div>
            <hr>
    </div>
</div>
<?php
if ($_SESSION) {
    $_SESSION['user'] = $data['user'];
    $user_id = $data['user']['id'];
}
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center pb-5">
        <div class="col-lg-8 col-md-10">
            <div class="card p-4">

                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="col-12 text-center">
                            <!-- <h2><strong><?= APP_NAME ?></strong></h2> -->
                            <img src="<?= IMAGE_PATH . 'logao.png' ?>" class="img-fluid me-2 rounded" style="height: 50px;">
                            <h2 class="text-center p-2" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><strong>RESERVAS</strong></h2>
                            <hr>
                        </div>


                        <form action="?ct=main&mt=nova_reserva_submit" method="post" class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="text_inicio" class="form-label">
                                            <h5>Data e hora de inicio</h5>
                                        </label>
                                        <input type="datetime-local" name="text_inicio" id="text_inicio" class="form-control">
                                    </div>
                                </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="text_fim" class="form-label">
                                                <h5>Data e hora de termino (tempo maximo de 2 horas)</h5>
                                            </label>
                                            <input type="datetime-local" name="text_fim" id="text_fim" class="form-control">
                                        </div>
                                    </div>


                                <div class="col-12">
                                    <h5>Salas de aula</h5>
                                    <div class="row">
                                        <!-- Colunas para Salas 1 a 4 -->
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_1" value="Sala 1 (Televisão, Kit multimídia)" checked>
                                                <label class="form-check-label" for="radio_1">
                                                    Sala 1 (Televisão, Kit multimídia)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_2" value="Sala 2 (Datashow, Kit multimídia)">
                                                <label class="form-check-label" for="radio_2">
                                                    Sala 2 (Datashow, Kit multimídia)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_3" value="Sala 3 (Televisão com DVD)">
                                                <label class="form-check-label" for="radio_3">
                                                    Sala 3 (Televisão com DVD)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_4" value="Sala 4 (Televisão com VCR)">
                                                <label class="form-check-label" for="radio_4">
                                                    Sala 4 (Televisão com VCR)
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Colunas para Salas 5 a 8 -->
                                        <div class="col-6 ps-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_5" value="Sala 5 (Projetor, Kit multimídia)">
                                                <label class="form-check-label" for="radio_5">
                                                    Sala 5 (Projetor, Kit multimídia)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_6" value="Sala 6 (Sistemas de áudio com amplificador e microfone)">
                                                <label class="form-check-label" for="radio_6">
                                                    Sala 6 (Sistemas de áudio com amplificador e microfone)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_7" value="Sala 7 (Informática & Notebooks)">
                                                <label class="form-check-label" for="radio_7">
                                                    Sala 7 (Informática & Notebooks)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sala" id="radio_8" value="Capela (Kit multimídia e instrumentos)">
                                                <label class="form-check-label" for="radio_8">
                                                    Capela (Kit multimídia e instrumentos)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-5 text-center">
                                    <a href="?ct=main&mt=index" class="btn btn-secondary"><i class="fa-solid fa-xmark me-2"></i>Cancelar</a>
                                    <button type="submit" class="btn btn-secondary"><i class="fa-regular fa-floppy-disk me-2"></i>Guardar</button>
                                </div>
                                <!-- tratamento de erros -->
                                <?php if (!empty($validation_errors)) : ?>
                                    <div class="alert alert-danger p-2 text-center">
                                        <?php foreach ($validation_errors as $error) : ?>
                                            <div><?= $error ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($server_error)) : ?>
                                    <div class="alert alert-danger p-2 text-center">
                                        <div><?= $server_error ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- coloca o valor max de duas horas no input text_fim (data final) -->
<script>
    document.getElementById('text_inicio').addEventListener('change', function() {
        var inicio = new Date(this.value);
        var fim = new Date(inicio.getTime() + 2 * 60 * 60 * 1000); // Adiciona 2 horas

        // Formata a data para o formato do input datetime-local
        var fimFormatado = fim.toISOString().slice(0, -8);

        document.getElementById('text_fim').max = fimFormatado;
        // fazer o min também 
        // e fazer o min do inicio
    });
</script>
<div class="container mt-5" >
    <h1>Tabela de Reservas</h1>
    <?php if (empty($data['reservas'])): ?>
        <br>
        <h3>Ainda não existem reservas. Faça uma agora mesmo -> <a href="?ct=main&mt=nova_reserva">Aqui!</a></h3>
        <button class="button btn-secondary" type="button"><a href="?ct=main&mt=index ">voltar</a></button>
    <?php else: ?>
        <div class="table-container border border-3 border-dark rounded-2 p-2" style="height: 60vh;;">
            <table class="table table-bordered table-dark table-striped mx-auto my-3" id="myTable">
                <thead style="color: white;">
                <tr>
                    <!-- <th>Excluir</th>
                    <th>Editar</th> -->
                    <th hidden>Id</th>
                    <th>Dia</th>
                    <th>Inicio</th>
                    <th>Fim</th>
                    <th>Professor</th>
                    <th>Sala / Equipamento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($data['reservas'] as $row) : ?>
                        <tr>
                            <!-- <td class="text-center pt-3"><i class="fas fa-solid fa-trash"></i></td>
                            <td class="text-center pt-3"><i class="fas fa-solid fa-pen-to-square"></i></td> -->
                            <td hidden><?= $row['id'] ?></td>
                            <td><strong><?= date('d/m/Y', strtotime($row['data_inicio']))?></strong></td>
                            <td><strong><?= date('H:i', strtotime($row['data_inicio']))?></strong></td>
                            <td><strong><?= date('H:i', strtotime($row['data_fim']))?></strong></td>
                            <td><?= $row['professor'] ?></td>
                            <td><?= $row['sala'] ?></td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>

// $(document).ready(function() {
//     new DataTable('#myTable',{
//         order: [[12, 'desc']]
//     });
// });


    
</script>
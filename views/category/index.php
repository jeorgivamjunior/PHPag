<?php
/** @var $models \models\Category[] */
?>

<div class="row">
    <h2 class="text-center">Categorias</h2>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <a class="btn btn-primary" href="category/create">Novo</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <tr>
                            <td>Nome</td>
                            <td>#</td>
                        </tr>
                        <?php foreach ($models as $model): ?>
                            <tr>
                                <td><?= $model->name ?></td>
                                <td>
                                    <a href="category/update/<?= $model->id ?>">Editar</a>
                                    <a onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                       href="category/delete/<?= $model->id ?>">Apagar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/** @var $modelsToPay \models\Bill[] */
/** @var $modelsToReceive \models\Bill[] */
/** @var $billsToReceiveFiltered \models\Bill[] */
/** @var $billsToPayFiltered \models\Bill[] */
/** @var $category \models\Category */
?>
<div class="row">
    <?php include('_search.php') ?>

    <h2 class="text-center">
        Contas
    </h2>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    <a class="btn btn-success" href="bill/receive">Nova conta a receber</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php foreach ($billsToReceiveFiltered as $category_id => $models): ?>
                            <table class="table table-condensed table-striped">
                                <caption><b> Categoria: </b> <?= $category->findOne($category_id)->name ?></caption>
                                <tr>
                                    <th>Título</th>
                                    <th>Total</th>
                                    <th>Pago</th>
                                    <th>Data</th>
                                    <th>Recorrente</th>
                                    <th>Ações</th>
                                </tr>
                                <?php foreach ($modelsToReceive as $model): ?>
                                    <tr>
                                        <td><?= $model->name ?></td>
                                        <td><?= "R$ " . number_format($model->total, 2, ',', '.') ?></td>
                                        <td><?= $model->paid ? "Sim" : "Não" ?></td>
                                        <td><?= date('d/m/Y', strtotime($model->due)) ?></td>
                                        <td><?= $model->recurrent ? "Sim" : "Não" ?></td>
                                        <td>
                                            <a href="bill/update/<?= $model->id ?>">Editar</a>
                                            <a onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                               href="bill/delete/<?= $model->id ?>">Apagar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endforeach; ?>
                        <?= empty($billsToReceiveFiltered) ? "Nada há contas" : "" ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    <a class="btn btn-danger" href="bill/pay">Nova conta a pagar</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php foreach ($billsToPayFiltered as $category_id => $models): ?>
                            <table class="table table-condensed table-striped">
                                <caption><b> Categoria: </b> <?= $category->findOne($category_id)->name ?></caption>
                                <tr>
                                    <th>Título</th>
                                    <th>Total</th>
                                    <th>Pago</th>
                                    <th>Data</th>
                                    <th>Recorrente</th>
                                    <th>Ações</th>
                                </tr>
                                <?php foreach ($modelsToPay as $model): ?>
                                    <tr>
                                        <td><?= $model->name ?></td>
                                        <td><?= "R$ " . number_format($model->total, 2, ',', '.') ?></td>
                                        <td><?= $model->paid ? "Sim" : "Não" ?></td>
                                        <td><?= date('d/m/Y', strtotime($model->due)) ?></td>
                                        <td><?= $model->recurrent ? "Sim" : "Não" ?></td>
                                        <td>
                                            <a href="bill/update/<?= $model->id ?>">Editar</a>
                                            <a onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                               href="bill/delete/<?= $model->id ?>">Apagar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endforeach; ?>
                        <?= empty($billsToPayFiltered) ? "Nada há contas" : "" ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/** @var $modelsToPay \models\Bill[] */
/** @var $modelsToReceive \models\Bill[] */
/** @var $billsToReceiveFiltered \models\Bill[] */
/** @var $billsToPayFiltered \models\Bill[] */
/** @var $category \models\Category */
$due = isset($_GET['due']) ? $_GET['due'] : "";
if (empty($due)) {
    $searchModel = date('Y-m');
} else {
    list($m, $y) = explode('/', $due);
    $searchModel = "$y-$m";
}
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
                    <div class="panel-title text-center">Contas à receber</div>
                    <a class="btn btn-success" href="bill/receive">Nova conta à receber</a>
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
                                <?php foreach ($modelsToReceive as $model):
                                    $modelDue = date('Y-m', strtotime($model->due));
                                    $notExist = $modelDue < $searchModel;
                                    ?>
                                    <tr>
                                        <td><?= $model->name ?></td>
                                        <td>
                                            <?= "R$ " . number_format($model->total, 2, ',', '.') ?> -
                                            <?= "R$ " . number_format($model->discount, 2, ',', '.') ?> =
                                            <?= "R$ " . number_format($model->total - $model->discount, 2, ',', '.') ?>
                                        </td>
                                        <td><?= $model->paid && !$notExist ? "Sim" : "Não" ?></td>
                                        <td><?=
                                            $notExist ?
                                                date('d', strtotime($model->due)) . "/$due" :
                                                date('d/m/Y', strtotime($model->due))
                                            ?></td>
                                        <td><?= !is_null($model->period) ? "Sim" : "Não" ?></td>
                                        <td>
                                            <a style="display: <?= $modelDue < $searchModel || $model->paid ? 'none' : '' ?>"
                                               href="bill/update/<?= base64_encode($model->id . "/" . $model->due) ?>">Editar</a>
                                            <a style="display: <?= $modelDue < $searchModel || $model->paid ? 'none' : '' ?>"
                                               onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                               href="bill/delete/<?= base64_encode($model->id . "/" . $model->due) ?>">Apagar</a>
                                            <span style="display: <?= $modelDue < $searchModel ? '' : 'none' ?>">Conta ainda não lançada</span>
                                            <span style="display: <?= $model->paid && !$notExist ? '' : 'none' ?>">Conta ja quitada</span>
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
                    <div class="panel-title text-center">Contas à pagar</div>
                    <a class="btn btn-danger" href="bill/pay">Nova conta à pagar</a>
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
                                <?php foreach ($modelsToPay as $model):
                                    $modelDue = date('Y-m', strtotime($model->due));
                                    $notExist = $modelDue < $searchModel;
                                    ?>
                                    <tr>
                                        <td><?= $model->name ?></td>
                                        <td>
                                            <?= "R$ " . number_format($model->total, 2, ',', '.') ?> -
                                            <?= "R$ " . number_format($model->discount, 2, ',', '.') ?> =
                                            <?= "R$ " . number_format($model->total - $model->discount, 2, ',', '.') ?>
                                        </td>
                                        <td><?= $model->paid && !$notExist ? "Sim" : "Não" ?></td>
                                        <td><?=
                                            $notExist ?
                                                date('d', strtotime($model->due)) . "/$due" :
                                                date('d/m/Y', strtotime($model->due))
                                            ?></td>
                                        <td><?= !is_null($model->period) ? "Sim" : "Não" ?></td>
                                        <td>
                                            <a style="display: <?= $modelDue < $searchModel || $model->paid ? 'none' : '' ?>"
                                               href="bill/update/<?= base64_encode($model->id . "/" . $model->due) ?>">Editar</a>
                                            <a style="display: <?= $modelDue < $searchModel || $model->paid ? 'none' : '' ?>"
                                               onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                               href="bill/delete/<?= base64_encode($model->id . "/" . $model->due) ?>">Apagar</a>
                                            <span style="display: <?= $modelDue < $searchModel ? '' : 'none' ?>">Conta ainda não lançada</span>
                                            <span style="display: <?= $model->paid && !$notExist ? '' : 'none' ?>">Conta ja quitada</span>
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
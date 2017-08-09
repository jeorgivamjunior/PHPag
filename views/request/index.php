<?php
/** @var $models \models\Request[] */
?>

<div class="row">
    <h2 class="text-center">Orçamentos</h2>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <a class="btn btn-primary" href="request/create">Novo</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php foreach ($models as $model): ?>
                        <table class="table table-condensed table-striped">
                            <caption class="text-center">
                                Orçamento #<?= $model->id ?> em <?= date('d/m/Y H:i', strtotime($model->created_at)) ?>
                                <a class="pull-right" onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                   href="request/delete/<?= $model->id ?>">Apagar</a>
                            </caption>
                            <?php foreach ($model->getProducts() as $product): ?>
                                <tr>
                                    <td><?= $product->name ?></td>
                                    <td><?= "R$ " . number_format($product->price, 2, ',', '.') ?></td>
                                    <td> <?= $product->amount ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" align="right">
                                    <?= "R$ " . number_format($model->total, 2, ',', '.') ?>
                                </td>
                            </tr>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/** @var $models \models\Bill[] */
/** @var $productsFiltered \models\Bill[] */
/** @var $category \models\Category */
?>
<div class="row">
    <h2 class="text-center">Contas</h2>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <a class="btn btn-success" href="bill/receive">Nova a conta receber</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php foreach ($productsFiltered as $category_id => $models): ?>
                        <table class="table table-condensed table-striped">
                            <caption><?= $category->findOne($category_id)->name ?></caption>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= $model->name ?></td>
                                    <td><?= "R$ " . number_format($model->price, 2, ',', '.') ?></td>
                                    <td>
                                        <a href="product/update/<?= $model->id ?>">Editar</a>
                                        <a onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                           href="product/delete/<?= $model->id ?>">Apagar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <a class="btn btn-danger" href="bill/pay">Nova conta a pagar</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php foreach ($productsFiltered as $category_id => $models): ?>
                        <table class="table table-condensed table-striped">
                            <caption><?= $category->findOne($category_id)->name ?></caption>
                            <?php foreach ($models as $model): ?>
                                <tr>
                                    <td><?= $model->name ?></td>
                                    <td><?= "R$ " . number_format($model->price, 2, ',', '.') ?></td>
                                    <td>
                                        <a href="product/update/<?= $model->id ?>">Editar</a>
                                        <a onclick="if(!confirm('Deseja apagar este item?')){return false}"
                                           href="product/delete/<?= $model->id ?>">Apagar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

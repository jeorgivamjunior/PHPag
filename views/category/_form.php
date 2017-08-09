<?php
/** @var $model \models\Product */
?>

<form method="post">
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('name') ?>
        </div>
        <input name="name" value="<?= $model->name ?>" title="" class="form-control">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
<?php
/** @var $model \models\User */
?>

<form method="post">
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('name') ?>
        </div>
        <input name="name" value="<?= $model->name ?>" title="" class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('email') ?>
        </div>
        <input name="email" value="<?= $model->email ?>" title="" class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('password') ?>
        </div>
        <input name="password" value="<?= $model->password ?>" title="" type="text"
               class="form-control">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
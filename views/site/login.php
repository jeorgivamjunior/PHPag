<?php
/** @var $model \models\LoginForm */
?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-body">
                <form method="post">
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
                        <input name="password" value="<?= $model->password ?>" title="" type="password"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Entrar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
/** @var $model \models\LoginForm */
?>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <form method="post">
                <h1>Acesso Sistema</h1>
                <div>
                    <input autofocus name="email" value="<?= $model->email ?>" type="text" class="form-control"
                           placeholder="<?= $model->getLabel('email') ?>" required=""/>
                </div>
                <div>
                    <input name="password" value="<?= $model->password ?>" type="password" class="form-control"
                           placeholder="<?= $model->getLabel('password') ?>"
                           required=""/>
                </div>
                <div>
                    <input type="submit" class="btn btn-default center-margin" style="margin: 0" value="Entrar">
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br/>

                    <div>
                        <h1><i class="fa fa-money"></i> PHPag</h1>
                        <p>
                            ©2017 All Rights Reserved.
                        </p>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
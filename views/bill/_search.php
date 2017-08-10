<?php
/** @var $categories \models\Category[] */
/** @var $model \models\Bill */
?>
<script type="text/javascript">
    $(function () {
        $('input[name="due"]').datepicker({
            todayHighlight: true,
            Boolean: true
        });
    });
</script>
<div class="row">
    <h2 class="text-center">Filtros</h2>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="control-label">
                                        Mes/Ano
                                    </div>
                                    <div class="input-group date">
                                        <input name="due" class="form-control" title="">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Procurar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
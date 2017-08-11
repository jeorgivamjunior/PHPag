<?php
/** @var $categories \models\Category[] */
/** @var $modelSearchToPay \models\Bill */
?>
<div class="row">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <div class="control-label">
                                        Mes/Ano
                                    </div>
                                    <div class="input-group date"
                                         data-provide="datepicker"
                                         data-date-format='mm/yyyy'
                                         data-date-min-view-mode="months"
                                         data-date-autoclose="true"
                                    >
                                        <input name="due" class="form-control" title=""
                                               value="<?= $modelSearchToPay->due ?>">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Procurar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
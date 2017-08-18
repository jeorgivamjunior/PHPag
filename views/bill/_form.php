<?php
/** @var $categories \models\Category[] */
/** @var $model \models\Bill */
?>

<script>
    $(function () {
        var limit = 881.90;
        $('select[name="recurrent"]').on('change', function () {
            $('#period').toggle();
        });

        var total = $('input[name="total"]');
        total.maskMoney({thousands: '.', decimal: ','});
        total.maskMoney('mask', <?= $model->total ?>);

        var discount = $('input[name="discount"]');
        discount.maskMoney({thousands: '.', decimal: ','});
        discount.maskMoney('mask', <?= $model->discount ?>);


        $('form').on('submit', function () {
            var title = $('input[name="name"]');
            var category = $('select[name="category_id"]');
            var due = $('input[name="due"]');
            if (total.val() && title.val() && category.val() && due.val()) {
                if (limit < parseInt(total.val())) {
                    alert("O valor total não pode ser maior que " + limit);
                    return false;
                }
            } else {
                alert("Preencha os campos obrigatórios");
                return false;
            }

            total.val(total.maskMoney('unmasked')[0]);
            discount.val(discount.maskMoney('unmasked')[0]);
        });
    });
</script>
<form method="post">
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('name') ?>
        </div>
        <input name="name" value="<?= $model->name ?>" title="" class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('category_id') ?>
        </div>
        <select title="" class="form-control" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= ($category->id == $model->category_id) ? "selected" : "" ?>>
                    <?= $category->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= ($model->pay_or_receive) ? "Data para entrada" : $model->getLabel('due') ?>
        </div>
        <input name="due" value="<?= $model->due ?>" title="" type="date"
               class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            Recorrente
        </div>
        <select name="recurrent" title="" class="form-control">
            <option value="0" <?= is_null($model->period) ? "" : "selected" ?>>Não</option>
            <option value="1" <?= !is_null($model->period) ? "selected" : "" ?>>Sim</option>
        </select>
    </div>
    <div class="form-group" id="period" style="display: <?= !is_null($model->period) ? 'block' : 'none' ?>">
        <div class="control-label">
            <?= $model->getLabel('period') ?>
        </div>
        <input name="period" value="<?= $model->period ?>" title="" type="text"
               placeholder="zero caso não tenha duração limitada"
               class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('total') ?>
        </div>
        <input name="total" value="<?= $model->total ?>" title="" type="text"
               class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('discount') ?>
        </div>
        <input name="discount" value="<?= $model->discount ?>" title="" type="text"
               class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('paid') ?>
        </div>
        <select name="paid" title="" class="form-control">
            <option value="0" <?= $model->paid ? "" : "selected" ?>>Não</option>
            <option value="1" <?= $model->paid ? "selected" : "" ?>>Sim</option>
        </select>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
<?php
/** @var $productsFiltered \models\Product[] */
/** @var $model \models\Request */
/** @var $category \models\Category */
/** @var $modelProducts \models\RequestHasProduct */
?>

<script>
    $(function () {
        $('input[name="removeProduct"]').on('click', function () {
            var index = $(this).data('index');
            $('input[name="removeProductIndex"]').val(index);
        });
    })
</script>

<form method="post">
    <?php foreach ($modelProducts as $key => $modelProduct): ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="control-label">
                        Produtos
                    </div>
                    <select title="" class="form-control multiple-select" name="Products[<?= $key ?>][product_id]">
                        <?php foreach ($productsFiltered as $category_id => $products): ?>
                            <optgroup label="<?= $category->findOne($category_id)->name ?>">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product->id ?>" <?= ($product->id == $modelProduct->product_id) ? "selected" : "" ?>>
                                        <?= $product->name . " (R$ " . number_format($product->price, 2, ',', '.') . ") " ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="control-label">
                        Quantidade
                    </div>
                    <input title="" class="form-control"
                           name="Products[<?= $key ?>][amount]"
                           value="<?= $modelProduct->amount ?>">
                </div>
            </div>
            <div class="col-md-4">
                <input type="submit" name="removeProduct" data-index="<?= $key ?>" class="btn btn-danger"
                       value="Remover Produto">
            </div>
        </div>
    <?php endforeach; ?>
    <input type="hidden" name="removeProductIndex" class="btn btn-danger">

    <input type="submit" name="addNewProduct" class="btn btn-primary" value="Adicionar Outro Produto">

    <div class="row">
        <div class="col-md-12">
            <hr>
            <h2 class="pull-left">Total:</h2>
            <h2 class="pull-right"><?= (empty($model->total)) ? "R$ 0,00" : "R$ " . number_format($model->total, 2, ',', '.') ?></h2>
        </div>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Salvar">
        <input class="btn btn-primary pull-right" name="Calculate" type="submit" value="Calcular">
    </div>
</form>
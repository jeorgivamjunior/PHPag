<?php
/** @var $categories \models\Category[] */
/** @var $model \models\Bill */
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
            <?= $model->getLabel('price') ?>
        </div>
        <input id="currency" name="price" value="<?= $model->price ?>" title="" type="text"
               class="form-control">
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= $model->getLabel('due') ?>
        </div>
        <input name="price" value="<?= $model->due ?>" title="" type="date"
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
        <input class="btn btn-primary" type="submit" value="Salvar">
    </div>
</form>
<?php
/** @var \yii\web\View $this */
/** @var \app\models\Issue $issue */
/** @var \app\models\Issue|null $parent */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project" class="breadcrumb__section breadcrumb__section--link">Lightness</a>
    <?php if ($parent): ?>
        <span class="breadcrumb__divisor"></span>
        <a href="/web/index.php?r=todo&id=<?= $parent->id ?>" class="breadcrumb__section breadcrumb__section--link"><?= $parent->title ?></a>
    <?php endif ?>
</div>
<div class="box">
    <div class="issue">
        <span class="issue__title"><?= $issue->title ?></span>
        <span class="issue__status">Статус: <?php echo $issue->checked ? 'Выполнено' : 'Не выполнено' ?></span>
    </div>
</div>
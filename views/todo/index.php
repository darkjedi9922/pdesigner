<?php
/** @var \yii\web\View $this */
/** @var \app\models\Issue $issue */
/** @var \app\models\Issue|null $parent */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project" class="breadcrumb__section breadcrumb__section--link">Lightness</a>
</div>
<div class="box">
    <div class="issue">
        <span class="issue__title"><?= $issue->title ?></span>
        <?php if ($text): ?>
            <span class="issue__text"><?= $text ?></span>
        <?php endif ?>
        <span class="issue__status">Статус: <?php echo $issue->checked ? 'Выполнено' : 'Не выполнено' ?></span>
    </div>
</div>
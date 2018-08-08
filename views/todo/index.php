<?php
/** @var \yii\web\View $this */
/** @var \app\models\Issue $issue */
/** @var \app\models\Issue|null $parent */
/** @var \app\models\Project $project */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project&id=<?= $project->id ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
</div>
<div class="box">
    <div class="issue" id="issue-app">
        <span class="issue__title">#<?= $issue->number ?> <?= $issue->title ?></span>
        <?php if ($text): ?>
            <span class="issue__text"><?= str_replace("\n", '<br>', $text) ?></span>
        <?php endif ?>
        <span class="issue__status">Статус: <?php echo $issue->checked ? 'Выполнено' : 'Не выполнено' ?></span>
    </div>
</div>
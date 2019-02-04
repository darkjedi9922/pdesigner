<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\Issue $item */
/** @var \app\models\Project $project */
/** @var string $text */
?>

<script>

var _taskFormAppOuterData = {
    csrfToken: '<?= Yii::$app->request->csrfToken ?>',
    yiiModel: 'EditTaskForm',
    title: '<?= $item->title ?>',
    text: '<?= str_replace(["\r", "\n"], ['\r', '\n'], $text) ?>'
};

</script>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Редактировать задачу</span>
</div>
<div class="box">
    <div id="task-form-app"></div>
</div>
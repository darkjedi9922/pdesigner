<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\modules\todo\models\Issue $item */
/** @var \app\modules\project\models\Project $project */
/** @var string $text */
?>

<script>

var _editTaskFormAppOuterData = {
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
    <div id="edit-task-form-app"></div>
</div>
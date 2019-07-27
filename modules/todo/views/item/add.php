<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\modules\todo\models\Issue|null $parent */
/** @var \app\modules\project\models\Project $project */
/** @var \app\modules\todo\models\IssueGroup $group */

?>

<script>

var _addTaskFormAppOuterData = {
    csrfToken: '<?= Yii::$app->request->csrfToken ?>',
    yiiModel: 'AddTaskForm',
    parentId: <?= $parent ? $parent->id : 'null' ?>,
    groupId: <?= $group->id ?>
};

</script>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Добавить задачу</span>
</div>
<div class="box">
    <?php if ($parent) : ?>
        <div class="form__field">
            <span class="form__label">Задача: <?= $parent->title ?></span>
        </div>
    <?php endif ?>
    <div id="add-task-form-app"></div>
</div>
<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\modules\todo\models\Issue|null $parent */
/** @var \app\modules\project\models\Project $project */
/** @var \app\modules\todo\models\IssueGroup $group */

if ($parent) {
    // Так как у нас уже есть объект родителя, повторно его искать не надо - найдем
    // его родителей, а потом добавим его в начало.
    $parents = $parent->findParents();
    array_unshift($parents, $parent);
} else {
    // Если родителя нет, очевидно и никаких прародителей нет тоже.
    $parents = [];
}
?>

<script>
    var _addTaskFormAppOuterData = {
        csrfToken: '<?= Yii::$app->request->csrfToken ?>',
        yiiModel: 'AddTaskForm',
        parentId: <?= $parent ? $parent->id : 'null' ?>,
        groupId: <?= $group->id ?>,
        parents: []
    };

    <?php for ($i = count($parents) - 1; $i >= 0; --$i): $parent = $parents[$i] ?>
        _addTaskFormAppOuterData.parents.push({
            id: <?= $parent->id ?>,
            status: <?= $parent->status ?>,
            number: <?= $parent->number ?>,
            title: '<?= $parent->title ?>',
            url: '<?= Url::to(['/todo', 'id' => $parent->id]) ?>'
        })
    <?php endfor ?>
</script>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section"><?= $group->name ?></span>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Добавить задачу</span>
</div>
<div id="add-task-form-app"></div>
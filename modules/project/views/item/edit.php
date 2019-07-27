<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Project $project */
/** @var app\models\ProjectDescription|null $desc */

?>

<script>

var _editProjectFormAppData = {
    csrfToken: '<?= Yii::$app->request->csrfToken ?>',
    yiiModel: 'EditProjectForm',
    name: '<?= $project->name ?>',
    description: '<?= $desc ? str_replace(["\n", "\r"], ['\n', '\r'], $desc->description) : '' ?>'
};

</script>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
</div>
<div class="box">
    <div id="edit-project-form-app"></div>
</div>
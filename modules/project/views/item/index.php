<?php

use yii\helpers\Url;

/** @var \app\modules\project\models\Project $project */
/** @var \app\modules\project\models\ProjectDescription|null $desc */
/** @var array $issues */
/** @var array $groups */
?>

<script>
    var _projectAppData = {
        projectId: <?= $project->id ?>,
        description: '<?= $desc ? str_replace(["\r", "\n"], ['\r', '\n'], $desc->description) : '' ?>',
        list: [<?php foreach ($issues as $issue): ?>{
            id: <?= $issue->id ?>,
            number: <?= $issue->number ?>,
            title: '<?= $issue->title ?>',
            parentId: <?= $issue->parent_issue_id ?? 0 ?>,
            groupId: <?= $issue->group_id ?>,
            status: <?= $issue->status ?>
        },<?php endforeach ?>],
        groups: {<?php foreach ($groups as $group): ?><?= $group->id ?>: {
            id: <?= $group->id ?>,
            name: '<?= $group->name ?>',
            colorId: <?= $group->color_id ?>
        },<?php endforeach ?>},
        mode: 'undone',
        token: '<?= Yii::$app->request->csrfToken ?>',
        urlEditProject: '<?= Url::to(['/project/item/edit', 'id' => $project->id]) ?>',
        urlDeleteProject: '<?= Url::to(['/project/item/delete', 'id' => $project->id]) ?>'
    };
</script>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section"><?= $project->name ?></span>
</div>
<div id="project-app"></div>
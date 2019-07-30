<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\modules\todo\models\Issue $issue */
/** @var \app\modules\todo\models\Issue|null $parent */
/** @var \app\modules\project\models\Project $project */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
</div>
<script>
    var _issueAppData = {
        id: <?= $issue->id ?>,
        status: <?= $issue->status ?>,
        token: '<?= Yii::$app->request->csrfToken ?>',
        number: <?= $issue->number ?>,
        title: '<?= $issue->title ?>',
        text: '<?= str_replace(["\r", "\n"], ['\r', '<br>'], $text) ?>',
        addItemUrl: '<?= Url::to(['/todo/item/add', 'parent' => $issue->id]) ?>',
        editItemUrl: '<?= Url::to(['/todo/item/edit', 'id' => $issue->id]) ?>',
        deleteItemUrl: '<?= Url::to(['/todo/item/delete', 'id' => $issue->id]) ?>'
    }
</script>
<div id="issue-app"></div>
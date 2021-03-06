<?php

use yii\helpers\Url;
use app\modules\todo\models\Issue;
use app\modules\todo\models\IssueGroup;

/** @var \yii\web\View $this */
/** @var \app\modules\todo\models\Issue $issue */
/** @var \app\modules\todo\models\Issue|null $parent */
/** @var \app\modules\project\models\Project $project */
/** @var string $text */

$parents = $issue->findParents();
$group = IssueGroup::findOne($issue->group_id);
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a 
        href="<?= Url::to(['/project', 'id' => $project->id]) ?>" 
        class="breadcrumb__section breadcrumb__section--link"
    ><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section"><?= $group->name ?></span>
</div>
<script>
    var _issueAppData = {
        id: <?= $issue->id ?>,
        status: <?= $issue->status ?>,
        token: '<?= Yii::$app->request->csrfToken ?>',
        number: <?= $issue->number ?>,
        title: '<?= $issue->title ?>',
        text: '<?= str_replace(["\r", "\n"], ['\r', '\n'], $text) ?>',
        addItemUrl: '<?= Url::to(['/todo/item/add', 'parent' => $issue->id]) ?>',
        editItemUrl: '<?= Url::to(['/todo/item/edit', 'id' => $issue->id]) ?>',
        deleteItemUrl: '<?= Url::to(['/todo/item/delete', 'id' => $issue->id]) ?>',
        parents: []
    };

    <?php for ($i = count($parents) - 1; $i >= 0; --$i): $parent = $parents[$i] ?>
        _issueAppData.parents.push({
            id: <?= $parent->id ?>,
            status: <?= $parent->status ?>,
            number: <?= $parent->number ?>,
            title: '<?= $parent->title ?>',
            url: '<?= Url::to(['/todo', 'id' => $parent->id]) ?>'
        })    
    <?php endfor ?>
</script>
<div id="issue-app"></div>
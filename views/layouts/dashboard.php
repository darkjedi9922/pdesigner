<?php

use app\modules\project\models\Project;
use yii\helpers\Url;
$projects = Project::find()
    ->where(['author_id' => Yii::$app->user->id])
    ->orderBy('id ASC')->all();
?>

<?php $this->beginContent('@app/views/layouts/simple.php') ?>
<div class="container">
    <div class="menu" id="menu">
        <a href="<?= Url::to(['/']) ?>" class="menu-header">
            <span class="menu-header__title">PDesigner</span>
        </a>

        <?php foreach ($projects as $project) : ?>
            <a href="<?= Url::to(['/project', 'id' => $project['id']]) ?>" class="menu__item">
                <project-logo name="<?= $project['name'] ?>" class="project-logo--minified"></project-logo>
                <?= $project['name'] ?>
            </a>
        <?php endforeach ?>
        <a href="<?= Url::to(['/project/item/add']) ?>" class="menu__item">Добавить проект</a>
    </div>
    <div class="desk">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
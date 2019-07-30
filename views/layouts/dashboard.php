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
        <div class="menu__items" id="menu-content">
            <?php foreach ($projects as $project) : ?>
                <a href="<?= Url::to(['/project', 'id' => $project['id']]) ?>" class="menu__item">
                    <project-logo name="<?= $project['name'] ?>" class="project-logo--minified"></project-logo>
                    <span class="menu__label"><?= $project['name'] ?></span>
                </a>
            <?php endforeach ?>
            <?php if (count($projects) == 0): ?>
                <span class="menu__notice">Проектов пока нет</span>
            <?php endif ?>
        </div>
        <div class="menu__specials">
            <span class="menu__special menu__special--toggle" id="menu-toggle"><i class="icon chevron left"></i></span>
            <a href="<?= Url::to(['/']) ?>" class="menu__special menu__special--home"><i class="icon home"></i></a>
            <a href="<?= Url::to(['/dashboard']) ?>" class="menu__special menu__special--dashboard"><i class="icon cube"></i></a>
            <a href="<?= Url::to(['/project/item/add']) ?>" class="menu__special menu__special--add"><i class="icon plus circle"></i></a>
        </div>
    </div>
    <div class="desk">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
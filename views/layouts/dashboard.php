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
        <div class="menu__item menu__item--opened menu-item">
            <span class="menu-item__header"><i class="folder icon"></i>Проекты<i class="caret up icon"></i><i class="caret down icon"></i></span>
            <div class="menu-item__content">
                <?php foreach ($projects as $project): ?>
                    <a href="<?= Url::to(['/project', 'id' => $project['id']]) ?>" class="menu__item"><?= $project['name'] ?></a>
                <?php endforeach ?>
                <a href="<?= Url::to(['/project/item/add']) ?>" class="menu__item">Добавить проект</a>
            </div>
        </div>
        <div class="menu__item menu__item--opened menu-item">
            <span class="menu-item__header"><i class="address card icon"></i>Профиль<i class="caret up icon"></i><i class="caret down icon"></i></span>
            <div class="menu-item__content">
                <a href="#" class="menu__item">Настройки</a>
            </div>
        </div>
    </div>
    <div class="desk">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
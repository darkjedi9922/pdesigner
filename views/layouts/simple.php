<?php

/** @var \yii\web\View $this */
/** @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/web/favicon.png']);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->title ? Html::encode($this->title) : Yii::$app->name ?></title>
    <?= $this->head() ?>
</head>
<body>
<?= $this->beginBody() ?>

<?= $content ?>

<?= $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php

/** @var \yii\web\View $this */
/** @var $content string */

use yii\helpers\Html;
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->title ? Html::encode($this->title) : Yii::$app->name ?></title>
    <link rel="stylesheet" href="/web/css/site.css">
</head>
<body>
<?= $this->beginBody() ?>

<?= $content ?>

<?= $this->endBody() ?>
</body>
</html>
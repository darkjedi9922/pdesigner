<?php

namespace app\controllers\todo;

use Yii;
use yii\web\Controller;
use app\models\IssueGroup;

class GroupController extends Controller
{
    /**
     * This is an AJAX action
     * @param int $group Id of the group
     * @param int $color Id of the color
     */
    public function actionSetColor($group, $color)
    {
        IssueGroup::updateAll(['color_id' => $color], 'id =' . $group);
    }
}
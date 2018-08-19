<?php

namespace app\controllers\todo;

use Yii;
use yii\web\Controller;
use app\models\IssueGroup;

class GroupController extends Controller
{
    /**
     * @param int $group Id of the group
     * @param int $color Id of the color
     */
    public function actionSetColor($group, $color)
    {
        IssueGroup::updateAll(['color_id' => $color], 'id =' . $group);
    }

    /**
     * @param int $group Id of the group
     * @param int $name New name
     */
    public function actionSetName($group, $name)
    {
        IssueGroup::updateAll(['name' => $name], 'id =' . $group);
    }
}
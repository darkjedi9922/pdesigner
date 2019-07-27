<?php

namespace app\modules\todo\controllers;

use yii\web\Controller;
use app\modules\todo\models\IssueGroup;

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

    /**
     * @param int $project Id of the project
     * @return string Id новой группы
     */
    public function actionAdd($project)
    {
        $group = new IssueGroup();
        $group->name = 'Новая группа';
        $group->color_id = 4;
        $group->project_id = $project;
        $group->insert();
        echo json_encode([
            'id' => $group->id,
            'name' => $group->name,
            'color_id' => $group->color_id
        ]);
    }

    /**
     * @param int $group Id of the group
     */
    public function actionDelete($group)
    {
        IssueGroup::remove($group);
    }

    public function actionIndex()
    {
        return 'hello';
    }
}
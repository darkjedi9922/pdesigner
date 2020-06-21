<?php

namespace app\modules\todo\controllers;

use Yii;
use yii\web\Controller;
use app\modules\todo\models\Issue;
use yii\web\NotFoundHttpException;

class ChildrenController extends Controller
{
    public function actionIndex($id)
    {
        $issue = Issue::findOne($id);
        if (!$issue || !Yii::$app->user->can('viewIssue', ['issue' => $issue]))
            throw new NotFoundHttpException;

        $children = $this->loadFormattedChildren($issue);
        echo json_encode($children, JSON_PRETTY_PRINT);
    }

    private function loadFormattedChildren(Issue $parent)
    {
        $result = [];
        $children = $parent->loadChildren();
        foreach ($children as $issue) {
            $result[] = [
                'id' => $issue->id,
                'groupId' => $issue->group_id,
                'number' => $issue->number,
                'title' => $issue->title,
                'parentId' => $parent->id,
                'status' => $issue->status,
                'children' => $this->loadFormattedChildren($issue)
            ];
        }
        return $result;
    }
}
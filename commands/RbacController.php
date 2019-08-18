<?php namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\ProjectOwnerRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $projectOwnerRule = new ProjectOwnerRule;
        $auth->add($projectOwnerRule);

        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'View a project';
        $viewProject->ruleName = $projectOwnerRule->name;
        $auth->add($viewProject);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewProject);

        $auth->assign($user, 1);
    }
}
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

        $addProject = $auth->createPermission('addProject');
        $addProject->description = 'Add a project';
        $auth->add($addProject);

        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'View a project';
        $auth->add($viewProject);

        $viewOwnProject = $auth->createPermission('viewOwnProject');
        $viewOwnProject->description = 'View own project';
        $viewOwnProject->ruleName = $projectOwnerRule->name;
        $auth->add($viewOwnProject);
        $auth->addChild($viewOwnProject, $viewProject);

        $editProject = $auth->createPermission('editProject');
        $editProject->description = 'Edit a project';
        $auth->add($editProject);

        $editOwnProject = $auth->createPermission('editOwnProject');
        $editOwnProject->description = 'Edit own project';
        $editOwnProject->ruleName = $projectOwnerRule->name;
        $auth->add($editOwnProject);
        $auth->addChild($editOwnProject, $editProject);

        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'Delete a project';
        $auth->add($deleteProject);

        $deleteOwnProject = $auth->createPermission('deleteOwnProject');
        $deleteOwnProject->description = 'Delete own project';
        $deleteOwnProject->ruleName = $projectOwnerRule->name;
        $auth->add($deleteOwnProject);
        $auth->addChild($deleteOwnProject, $deleteProject);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $addProject);
        $auth->addChild($user, $viewOwnProject);
        $auth->addChild($user, $editOwnProject);
        $auth->addChild($user, $deleteOwnProject);

        $auth->assign($user, 1);
    }
}
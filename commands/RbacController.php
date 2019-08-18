<?php namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\ProjectOwnerRule;
use app\rbac\IssueOwnerRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $projectOwnerRule = new ProjectOwnerRule;
        $auth->add($projectOwnerRule);

        $issueOwnerRule = new IssueOwnerRule;
        $auth->add($issueOwnerRule);

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

        $addIssue = $auth->createPermission('addIssue');
        $addIssue->description = 'Add an issue';
        $auth->add($addIssue);

        $addIssueToOwnProject = $auth->createPermission('addIssueToOwnProject');
        $addIssueToOwnProject->description = 'Add an issue to own project';
        $addIssueToOwnProject->ruleName = $projectOwnerRule->name;
        $auth->add($addIssueToOwnProject);
        $auth->addChild($addIssueToOwnProject, $addIssue);

        $viewIssue = $auth->createPermission('viewIssue');
        $viewIssue->description = 'View an issue';
        $auth->add($viewIssue);

        $viewOwnIssue = $auth->createPermission('viewOwnIssue');
        $viewOwnIssue->description = 'View own issue';
        $viewOwnIssue->ruleName = $issueOwnerRule->name;
        $auth->add($viewOwnIssue);
        $auth->addChild($viewOwnIssue, $viewIssue);

        $toggleIssue = $auth->createPermission('toggleIssue');
        $toggleIssue->description = 'Toggle an issue';
        $auth->add($toggleIssue);

        $toggleOwnIssue = $auth->createPermission('toggleOwnIssue');
        $toggleOwnIssue->description = 'Toggle own issue';
        $toggleOwnIssue->ruleName = $issueOwnerRule->name;
        $auth->add($toggleOwnIssue);
        $auth->addChild($toggleOwnIssue, $toggleIssue);

        $editIssue = $auth->createPermission('editIssue');
        $editIssue->description = 'Edit an issue';
        $auth->add($editIssue);

        $editOwnIssue = $auth->createPermission('editOwnIssue');
        $editOwnIssue->description = 'Edit own issue';
        $editOwnIssue->ruleName = $issueOwnerRule->name;
        $auth->add($editOwnIssue);
        $auth->addChild($editOwnIssue, $editIssue);

        $deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'Delete an issue';
        $auth->add($deleteIssue);

        $deleteOwnIssue = $auth->createPermission('deleteOwnIssue');
        $deleteOwnIssue->description = 'Delete own issue';
        $deleteOwnIssue->ruleName = $issueOwnerRule->name;
        $auth->add($deleteOwnIssue);
        $auth->addChild($deleteOwnIssue, $deleteIssue);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $addProject);
        $auth->addChild($user, $viewOwnProject);
        $auth->addChild($user, $editOwnProject);
        $auth->addChild($user, $deleteOwnProject);
        $auth->addChild($user, $addIssueToOwnProject);
        $auth->addChild($user, $viewOwnIssue);
        $auth->addChild($user, $toggleOwnIssue);
        $auth->addChild($user, $editOwnIssue);
        $auth->addChild($user, $deleteOwnIssue);

        $auth->assign($user, 1);
    }
}
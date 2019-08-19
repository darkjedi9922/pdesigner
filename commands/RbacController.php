<?php namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\ProjectOwnerRule;
use app\rbac\IssueOwnerRule;
use yii\rbac\ManagerInterface;
use yii\rbac\Rule;

class RbacController extends Controller
{
    /** @var Rule */
    private $projectOwnerRule;

    /** @var Rule */
    private $issueOwnerRule;

    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $this->initRules($auth);
        $this->initProjectPermissions($auth);
        $this->initIssuePermissions($auth);
        $this->initRoles($auth);
    }

    private function initRules(ManagerInterface $auth)
    {
        $this->projectOwnerRule = new ProjectOwnerRule;
        $auth->add($this->projectOwnerRule);

        $this->issueOwnerRule = new IssueOwnerRule;
        $auth->add($this->issueOwnerRule);
    }

    private function initProjectPermissions(ManagerInterface $auth)
    {
        $addProject = $auth->createPermission('addProject');
        $addProject->description = 'Add a project';
        $auth->add($addProject);

        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'View a project';
        $auth->add($viewProject);

        $viewOwnProject = $auth->createPermission('viewOwnProject');
        $viewOwnProject->description = 'View own project';
        $viewOwnProject->ruleName = $this->projectOwnerRule->name;
        $auth->add($viewOwnProject);
        $auth->addChild($viewOwnProject, $viewProject);

        $editProject = $auth->createPermission('editProject');
        $editProject->description = 'Edit a project';
        $auth->add($editProject);

        $editOwnProject = $auth->createPermission('editOwnProject');
        $editOwnProject->description = 'Edit own project';
        $editOwnProject->ruleName = $this->projectOwnerRule->name;
        $auth->add($editOwnProject);
        $auth->addChild($editOwnProject, $editProject);

        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'Delete a project';
        $auth->add($deleteProject);

        $deleteOwnProject = $auth->createPermission('deleteOwnProject');
        $deleteOwnProject->description = 'Delete own project';
        $deleteOwnProject->ruleName = $this->projectOwnerRule->name;
        $auth->add($deleteOwnProject);
        $auth->addChild($deleteOwnProject, $deleteProject);
    }

    private function initIssuePermissions(ManagerInterface $auth)
    {
        $addIssue = $auth->createPermission('addIssue');
        $addIssue->description = 'Add an issue';
        $auth->add($addIssue);

        $addIssueToOwnProject = $auth->createPermission('addIssueToOwnProject');
        $addIssueToOwnProject->description = 'Add an issue to own project';
        $addIssueToOwnProject->ruleName = $this->projectOwnerRule->name;
        $auth->add($addIssueToOwnProject);
        $auth->addChild($addIssueToOwnProject, $addIssue);

        $viewIssue = $auth->createPermission('viewIssue');
        $viewIssue->description = 'View an issue';
        $auth->add($viewIssue);

        $viewOwnIssue = $auth->createPermission('viewOwnIssue');
        $viewOwnIssue->description = 'View own issue';
        $viewOwnIssue->ruleName = $this->issueOwnerRule->name;
        $auth->add($viewOwnIssue);
        $auth->addChild($viewOwnIssue, $viewIssue);

        $toggleIssue = $auth->createPermission('toggleIssue');
        $toggleIssue->description = 'Toggle an issue';
        $auth->add($toggleIssue);

        $toggleOwnIssue = $auth->createPermission('toggleOwnIssue');
        $toggleOwnIssue->description = 'Toggle own issue';
        $toggleOwnIssue->ruleName = $this->issueOwnerRule->name;
        $auth->add($toggleOwnIssue);
        $auth->addChild($toggleOwnIssue, $toggleIssue);

        $editIssue = $auth->createPermission('editIssue');
        $editIssue->description = 'Edit an issue';
        $auth->add($editIssue);

        $editOwnIssue = $auth->createPermission('editOwnIssue');
        $editOwnIssue->description = 'Edit own issue';
        $editOwnIssue->ruleName = $this->issueOwnerRule->name;
        $auth->add($editOwnIssue);
        $auth->addChild($editOwnIssue, $editIssue);

        $deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'Delete an issue';
        $auth->add($deleteIssue);

        $deleteOwnIssue = $auth->createPermission('deleteOwnIssue');
        $deleteOwnIssue->description = 'Delete own issue';
        $deleteOwnIssue->ruleName = $this->issueOwnerRule->name;
        $auth->add($deleteOwnIssue);
        $auth->addChild($deleteOwnIssue, $deleteIssue);
    }

    private function initRoles(ManagerInterface $auth)
    {
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $auth->getPermission('addProject'));
        $auth->addChild($user, $auth->getPermission('viewOwnProject'));
        $auth->addChild($user, $auth->getPermission('editOwnProject'));
        $auth->addChild($user, $auth->getPermission('deleteOwnProject'));
        $auth->addChild($user, $auth->getPermission('addIssueToOwnProject'));
        $auth->addChild($user, $auth->getPermission('viewOwnIssue'));
        $auth->addChild($user, $auth->getPermission('toggleOwnIssue'));
        $auth->addChild($user, $auth->getPermission('editOwnIssue'));
        $auth->addChild($user, $auth->getPermission('deleteOwnIssue'));

        $auth->assign($user, 1);
    }
}
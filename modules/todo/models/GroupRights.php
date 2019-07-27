<?php

namespace app\modules\todo\models;

use app\modules\users\Rights;
use app\modules\todo\models\IssueGroup;
use app\modules\project\models\Project;

class GroupRights extends Rights
{
    public function canSetName(IssueGroup $group): bool
    {
        $project = $this->findProject($group);
        return $this->userIsProjectAuthor($project);
    }

    public function canSetColor(IssueGroup $group): bool
    {
        return $this->canSetName($group);
    }

    public function canAdd(Project $project): bool
    {
        return $this->userIsProjectAuthor($project);
    }

    public function canDelete(IssueGroup $group): bool
    {
        return $this->canSetName($group);
    }

    private function findProject(IssueGroup $group): Project
    {
        return Project::findOne($group->project_id);
    }

    private function userIsProjectAuthor(Project $project): bool
    {
        return $project->author_id === $this->userId;
    }
}
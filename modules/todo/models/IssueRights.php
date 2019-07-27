<?php

namespace app\modules\todo\models;

use app\modules\users\Rights;
use app\modules\todo\models\Issue;
use app\modules\todo\models\IssueGroup;
use app\modules\project\models\Project;

class IssueRights extends Rights
{
    public function canAdd(IssueGroup $group): bool
    {
        $project = $this->findProjectOfGroup($group);
        return $this->userId === $project->author_id;
    }

    public function canSee(Issue $issue): bool
    {
        $project = $this->findProjectOfIssue($issue);
        return $project->author_id == $this->userId;
    }

    public function canToggle(Issue $issue): bool
    {
        return $this->canSee($issue);
    }

    public function canEdit(Issue $project): bool
    {
        return $this->canSee($project);
    }

    public function canDelete(Issue $project): bool
    {
        return $this->canSee($project);
    }

    private function findProjectOfIssue(Issue $issue): Project
    {
        $group = IssueGroup::findOne($issue->group_id);
        return $this->findProjectOfGroup($group);
    }

    private function findProjectOfGroup(IssueGroup $group): Project
    {
        return Project::findOne($group->project_id);
    }
}
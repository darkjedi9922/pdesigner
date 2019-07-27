<?php

namespace app\modules\project\models;

use app\modules\users\Rights;
use app\modules\project\models\Project;

class ProjectRights extends Rights
{
    public function canAdd(): bool
    {
        return $this->userId !== null;
    }

    public function canSee(Project $project): bool
    {
        return $project->author_id == $this->userId;
    }

    public function canEdit(Project $project): bool
    {
        return $this->canSee($project);
    }

    public function canDelete(Project $project): bool
    {
        return $this->canSee($project);
    }
}
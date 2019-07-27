<?php namespace app\modules\project\models;

use yii\base\Model;
use yii\helpers\Html;
use app\modules\project\models\Project;
use app\modules\project\models\ProjectDescription;
use app\modules\todo\models\IssueGroup;
use Yii;

class AddProjectForm extends Model
{
    public $name;
    public $description = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['description', 'string']
        ];
    }

    /**
     * @return Project|null
     */
    public function add()
    {
        if ($this->validate()) {
            // Сам проект
            $project = new Project();
            $project->name = Html::encode($this->name);
            $project->author_id = Yii::$app->user->id;
            $project->insert();
            
            // Его описание
            if ($this->description) {
                $desc = new ProjectDescription();
                $desc->project_id = $project->id;
                $desc->description = $this->description;
                $desc->insert();
            }
            
            // А также стандартная группа задач
            $group = new IssueGroup();
            $group->project_id = $project->id;
            $group->name = 'Общее';
            $group->insert();

            return $project;
        }
        return null;
    }
}
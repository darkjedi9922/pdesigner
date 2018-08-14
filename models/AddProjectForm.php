<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Project;
use app\models\ProjectDescription;

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
            $project->insert();
            // Его описание
            if ($this->description) {
                $desc = new ProjectDescription();
                $desc->project_id = $project->id;
                $desc->description = $this->description;
                $desc->insert();
            }
            return $project;
        }
        return null;
    }
}
<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Project;

class AddProjectForm extends Model
{
    public $name;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }

    /**
     * @return Project|null
     */
    public function add()
    {
        if ($this->validate()) {
            $project = new Project();
            $project->name = Html::encode($this->name);
            if ($project->insert()) return $project;
        }
        return null;
    }
}
<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Issue;

class AddTaskForm extends Model
{
    public $title;
    public $parent = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['parent', 'integer']
        ];
    }

    /**
     * @return bool было ли добавлено задание
     */
    public function add()
    {
        if ($this->validate()) {
            $issue = new Issue();
            $issue->project_id = 0;
            $issue->number = Issue::calcNewNumber();
            if ($this->parent) $issue->parent_issue_id = $this->parent;
            $issue->title = Html::encode($this->title);
            return $issue->insert();
        }
        return false;
    }
}
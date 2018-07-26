<?php namespace app\models;

use yii\base\Model;
use app\models\Issue;

class AddTaskForm extends Model
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required']
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
            $issue->title = $this->title;
            return $issue->insert();
        }
        return false;
    }
}
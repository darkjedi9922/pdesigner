<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Issue;

class AddTaskForm extends Model
{
    public $title;
    public $parent = null;
    public $text = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['parent', 'integer'],
            ['text', 'string']
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
            $issue->insert();
            if ($this->text) {
                $text = new IssueText();
                $text->issue_id = $issue->id;
                $text->text = Html::encode($this->text);
                $text->insert();
            }
            return true;
        }
        return false;
    }
}
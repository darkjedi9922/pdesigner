<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Issue;

class AddTaskForm extends Model
{
    public $title;
    public $parent = null;
    public $project = null;
    public $text = null;

    private $issue = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['parent', 'integer'],
            ['project', 'integer'],
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

            if ($this->parent) {
                $issue->parent_issue_id = $this->parent;
                $issue->project_id = Issue::findOne($this->parent)->project_id;
            } else if ($this->project) {
                $issue->parent_issue_id = null;
                $issue->project_id = $this->project;
            } else return false;

            $issue->number = Issue::calcNewNumber($issue->project_id);
            $issue->title = Html::encode($this->title);
            $issue->insert();
            if ($this->text) {
                $text = new IssueText();
                $text->issue_id = $issue->id;
                $text->text = Html::encode($this->text);
                $text->insert();
            }

            $this->issue = $issue;

            return true;
        }
        return false;
    }

    /**
     * @return Issue|null
     */
    public function getAddedIssue()
    {
        return $this->issue;
    }
}
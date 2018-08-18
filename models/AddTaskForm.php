<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Issue;

class AddTaskForm extends Model
{
    public $title;
    public $parentId = null;
    public $groupId = null;
    public $text = null;

    private $issue = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['parentId', 'integer'],
            ['groupId', 'integer'],
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

            if ($this->parentId) {
                $parent = Issue::findOne($this->parentId);
                $issue->parent_issue_id = $this->parentId;
                $issue->group_id = $parent->group_id;
                $issue->project_id = $parent->project_id;
            } else if ($this->groupId) {
                $group = IssueGroup::findOne($this->groupId);
                $issue->parent_issue_id = null;
                $issue->group_id = $this->groupId;
                $issue->project_id = $group->project_id;
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
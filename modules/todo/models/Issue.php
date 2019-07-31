<?php namespace app\modules\todo\models;

use Yii;
use yii\db\ActiveRecord;

class Issue extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issues';
    }

    /**
     * @param int $projectId
     */
    public static function calcNewNumber($projectId)
    {
        return Yii::$app->db->createCommand(
            'SELECT MAX(number) FROM '.self::tableName().' WHERE project_id = '.$projectId
        )->queryScalar() + 1;
    }

    /**
     * Возвращает issue, который принадлежит текущему пользователю. Если такого
     * issue не найдено, вернет null.
     * 
     * @param int $id
     * @return Issue|null
     */
    public static function findMyOne($id)
    {
        $userId = Yii::$app->user->id;
        return self::findBySql(
            "SELECT issues.*
            FROM issues INNER JOIN projects ON issues.project_id = projects.id
            WHERE issues.id = ${id} AND projects.author_id = ${userId}"
        )->one();
    }

    /**
     * Возвращает текущего пользователя ли эта задача (с его ли проекта).
     * 
     * @param int $issueId
     * @return bool
     */
    public function doesMeOwn()
    {
        $id = $this->id;
        $userId = Yii::$app->user->id;
        // Если берем id - первичный ключ - вернет либо 1 или 0 записей. При этом
        // связываем запись с автором проекта как id пользователя. Если с таким
        // автором запись не найдена (возвращено 0 записей), значит это не запись
        // пользователя.
        return (bool) Yii::$app->db->createCommand(
            "SELECT issues.id 
            FROM issues INNER JOIN projects ON issues.project_id = projects.id
            WHERE issues.id = ${id} AND projects.author_id = ${userId}"
        )->query()->count();
    }

    /**
     * Removes the issue and its text. 
     * The children is not removed.
     * 
     * {@inheritDoc}
     */
    public function delete()
    {
        if (!$this->doesMeOwn()) return false;
        IssueText::deleteAll('issue_id = ' . $this->id);
        return parent::delete();
    }

    /**
     * Возвращает массив объектов Issue, - родителей данной задачи в порядке
     * близости (сначала родитель, потом прародитель...).
     */
    public function findParents(): array
    {
        $result = [];
        for ($parent = $this; $parent->parent_issue_id !== null; ) {
            $parent = Issue::findOne($parent->parent_issue_id);
            $result[] = $parent;
        }
        return $result;
    }
}
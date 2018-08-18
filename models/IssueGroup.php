<?php namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class IssueGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_groups';
    }
}
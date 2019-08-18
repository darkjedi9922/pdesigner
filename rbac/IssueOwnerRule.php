<?php namespace app\rbac;

use yii\rbac\Rule;

class IssueOwnerRule extends Rule
{
    public $name = 'isIssueOwner';

    public function execute($user, $item, $params)
    {
        return isset($params['issue']) && 
            $params['issue']->findProject()->author_id == $user;
    }
}
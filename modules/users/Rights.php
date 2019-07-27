<?php

namespace app\modules\users;

use app\models\User;

class Rights
{
    /** @var int|null */
    protected $userId;

    public function __construct(?User $user)
    {
        $this->userId = $user ? $user->id : null;
    }
}
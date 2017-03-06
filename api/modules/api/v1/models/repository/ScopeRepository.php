<?php

namespace api\modules\api\v1\models\repository;

use yii\db\ActiveQuery;
use api\modules\api\v1\models\Scope;

/**
 * Class ScopeRepository
 *
 * @package api\modules\api\v1\models\repository
 */
class ScopeRepository extends ActiveQuery
{
    public function findAllowed($list)
    {
        $this->where([
            ['IN', 'name', $list]
        ])->orWhere([
            'is_default' => Scope::STATUS_DEFAULT
        ])->all();
    }
}

<?php

namespace app\extensions\securityManager\models\auto;

/**
 * This is the ActiveQuery class for [[SecurityBlockedAccess]].
 *
 * @see SecurityBlockedAccess
 */
class SecurityBlockedAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SecurityBlockedAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SecurityBlockedAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

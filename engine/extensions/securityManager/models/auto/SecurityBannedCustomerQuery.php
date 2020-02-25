<?php

namespace app\extensions\securityManager\models\auto;

/**
 * This is the ActiveQuery class for [[SecurityBannedCustomer]].
 *
 * @see SecurityBannedCustomer
 */
class SecurityBannedCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SecurityBannedCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SecurityBannedCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

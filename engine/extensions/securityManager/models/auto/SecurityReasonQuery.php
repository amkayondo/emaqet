<?php

namespace app\extensions\securityManager\models\auto;

/**
 * This is the ActiveQuery class for [[SecurityReason]].
 *
 * @see SecurityReason
 */
class SecurityReasonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SecurityReason[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SecurityReason|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

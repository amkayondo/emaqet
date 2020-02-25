<?php

namespace app\extensions\securityManager\models\auto;

/**
 * This is the ActiveQuery class for [[SecurityLog]].
 *
 * @see SecurityLog
 */
class SecurityLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SecurityLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SecurityLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

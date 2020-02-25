<?php

namespace app\extensions\securityManager\models\auto;

/**
 * This is the ActiveQuery class for [[SecurityInappropriateReport]].
 *
 * @see SecurityInappropriateReport
 */
class SecurityInappropriateReportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SecurityInappropriateReport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SecurityInappropriateReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

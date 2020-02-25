<?php

namespace app\extensions\securityManager\models\auto;

use Yii;

/**
 * This is the model class for table "{{%security_inappropriate_report}}".
 *
 * @property int    $inappropriate_report_id
 * @property int    $listing_id
 * @property int    $status
 * @property string $report_reason
 * @property string $report_notes
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class SecurityInappropriateReport extends \app\extensions\securityManager\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%security_inappropriate_report}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listing_id', 'status', 'report_reason', 'created_at', 'updated_at'], 'required'],
            [['listing_id', 'status'], 'integer'],
            [['report_notes'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['report_reason'], 'string', 'max' => 130],
            [['updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inappropriate_report_id' => 'Inappropriate Report ID',
            'listing_id'              => 'Listing ID',
            'status'                  => 'Status',
            'report_reason'           => 'Report Reason',
            'report_notes'            => 'Report Notes',
            'updated_by'              => 'Updated By',
            'created_at'              => 'Created At',
            'updated_at'              => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return SecurityInappropriateReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SecurityInappropriateReportQuery(get_called_class());
    }
}

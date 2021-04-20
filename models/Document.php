<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $cabinet_id
 * @property string $document_num
 * @property string $date
 * @property string $time
 * @property string|null $description
 *
 * @property DocumenStatusHistory[] $documenStatusHistories
 * @property Cabinet $cabinet
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cabinet_id', 'document_num', 'date', 'time'], 'required'],
            [['cabinet_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['description'], 'string'],
            [['document_num'], 'string', 'max' => 55],
            [['cabinet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cabinet::className(), 'targetAttribute' => ['cabinet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cabinet_id' => 'Cabinet ID',
            'document_num' => 'Document Num',
            'date' => 'Date',
            'time' => 'Time',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[DocumenStatusHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumenStatusHistories()
    {
        return $this->hasMany(DocumenStatusHistory::className(), ['document_id' => 'id']);
    }

    /**
     * Gets query for [[Cabinet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCabinet()
    {
        return $this->hasOne(Cabinet::className(), ['id' => 'cabinet_id']);
    }
}

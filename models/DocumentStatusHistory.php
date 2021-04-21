<?php
/**
 * @property int $id
 * @property int $document_id
 * @property string $date
 * @property string $time
 * @property string $status
 * @property \app\models\Document $document
 */

namespace app\models;


use yii\db\ActiveRecord;

class DocumentStatusHistory extends ActiveRecord
{
    public static function tableName()
    {
        return 'document_status_history';
    }

    public function rules()
    {
        return [
            [['document_id', 'date', 'time', 'status'], 'required'],
            [['document_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }
}
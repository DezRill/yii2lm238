<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cabinet".
 *
 * @property int $id
 * @property string $api_key
 * @property string|null $date_end
 * @property string $name
 * @property string|null $short_name
 * @property string $counterparty
 * @property string $contact_person
 * @property string|null $recipient_counterparty
 * @property string|null $town
 * @property string|null $dispatch_dep
 */
class Cabinet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cabinet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['api_key', 'name', 'counterparty', 'contact_person'], 'required', 'message' => 'Поле не должно быть пустым'],
            [['api_key'], 'string'],
            [['date_end'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'short_name', 'counterparty', 'contact_person', 'recipient_counterparty', 'town'], 'string', 'max' => 55],
            [['dispatch_dep'], 'string', 'max' => 255],
            [['counterparty', 'contact_person'], 'compare', 'compareValue' => '0', 'operator' => '!=', 'message' => 'Поле не должно быть пустым.']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api_key' => 'Ключ API',
            'date_end' => 'Дата окончания действия ключа',
            'name' => 'Название',
            'short_name' => 'Короткое название',
            'counterparty' => 'Контрагент',
            'contact_person' => 'Контактное лицо',
            'recipient_counterparty' => 'Контрагент получателя',
            'town' => 'Город',
            'dispatch_dep' => 'Отделение отправки',
        ];
    }
}

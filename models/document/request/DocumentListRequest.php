<?php

namespace app\models\document\request;

use app\models\Cabinet;
use app\models\document\response\DocumentListResponse;
use yii\httpclient\Client;

class DocumentListRequest extends DocumentBigOneBasic
{
    public $dateFrom;
    public $dateTo;

    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'required'],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'dd.mm.yyyy'],
            [['dateTo'], 'compare', 'compareAttribute' => 'dateFrom', 'operator' => '>='],
            ['apiKey', 'exist', 'targetAttribute' => 'api_key', 'targetClass' => Cabinet::class]
        ];
    }

    /**
     * @return array
     */
    public function getDocuments()
    {
        $client = new Client();
        $documentsList = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $this->apiKey,
                'modelName' => 'InternetDocument',
                'calledMethod' => 'getDocumentList',
                'methodProperties' => [
                    'DateTimeFrom' => $this->dateFrom,
                    'DateTimeTo' => $this->dateTo,
                    'GetFullList' => 1
                ]
            ])->send();

        $items[] = new DocumentListResponse();
        foreach ($documentsList->data['data'] as $item) {
            $modelItem = new DocumentListResponse();

            if ($item['Ref'] !== null) {
                $modelItem->ref = $item['Ref'];
                $modelItem->dateTime = $item['DateTime'];
                $modelItem->prefferedDeliveryDate = $item['PrefferedDeliveryDate'];
                $modelItem->weight = $item['Weight'] . ' кг';
                $modelItem->seatsAmount = $item['SeatsAmount'];
                $modelItem->intDocNumber = $item['IntDocNumber'];
                $modelItem->cost = $item['Cost'] . ' грн';
                $modelItem->citySender = $item['CitySender'];
                $modelItem->cityRecipient = $item['CityRecipient'];
                $modelItem->senderAddress = $item['SenderAddress'];
                $modelItem->recipientAddress = $item['RecipientAddress'];
                $modelItem->citySenderDescription = $item['CitySenderDescription'];
                $modelItem->cityRecipientDescription = $item['CityRecipientDescription'];
                $modelItem->senderAddressDescription = $item['SenderAddressDescription'];
                $modelItem->recipientAddressDescription = $item['RecipientAddressDescription'];
                $modelItem->costOnSite = $item['CostOnSite'] . ' грн';
                $modelItem->payerType = $item['PayerType'];
                $modelItem->paymentMethod = $item['PaymentMethod'];
                $modelItem->afterpaymentOnGoodsCost = $item['AfterpaymentOnGoodsCost'];
                $modelItem->packingNumber = $item['PackingNumber'];
                $modelItem->rejectionReason = $item['RejectedReason'];
            }

            if ($modelItem->prefferedDeliveryDate == null) $modelItem->prefferedDeliveryDate = 'Ожидание посылки от отправителя...';
            switch ($modelItem->payerType) {
                case 'Recipient':
                    $modelItem->payerType = 'Получатель';
                    break;
                case 'Sender':
                    $modelItem->payerType = 'Отправитель';
                    break;
                case 'ThirdPerson':
                    $modelItem->payerType = 'Третье лицо';
                    break;
            }
            switch ($modelItem->paymentMethod) {
                case 'Cash':
                    $modelItem->paymentMethod = 'Наличный расчёт';
                    break;
                case 'NonCash':
                    $modelItem->paymentMethod = 'Безналичный расчёт';
                    break;
            }
            array_push($items, $modelItem);
        }

        array_shift($items);
        return $items;
    }
}
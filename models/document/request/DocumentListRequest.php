<?php

namespace app\models\document\request;

use app\models\Cabinet;
use app\models\document\response\DocumentListResponse;
use yii\httpclient\Client;

class DocumentListRequest extends DocumentBasic
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

        /*$documentsList=$client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $this->apiKey,
                'modelName' => 'TrackingDocument',
                'calledMethod' => 'getStatusDocuments',
                'methodProperties' => [
                    'Documents' => [
                        ['DocumentNumber' => '20450375811493'],
                        ['DocumentNumber' => '20450375760190'],
                    ]
                ]
            ])->send();*/

        /*$items[] = new DocumentListResponse();
        foreach ($documentsList->data['data'] as $item)
        {
            $modelItem=new DocumentListResponse();

            $modelItem->ref=$item['Ref'];
            $modelItem->dateTime=$item['DateTime'];
            $modelItem->prefferedDeliveryDate=$item['PrefferedDeliveryDate'];
            $modelItem->weight=$item['Weight'];
            $modelItem->seatsAmount=$item['SeatsAmount'];
            $modelItem->intDocNumber=$item['IntDocNumber'];
            $modelItem->cost=$item['Cost'];
            $modelItem->citySender=$item['CitySender'];
            $modelItem->cityRecipient=$item['CityRecipient'];
            $modelItem->senderAddress=$item['SenderAddress'];
            $modelItem->recipientAddress=$item['RecipientAddress'];
            $modelItem->costOnSite=$item['CostOnSite'];
            $modelItem->payerType=$item['PayerType'];
            $modelItem->paymentMethod=$item['PaymentMethod'];
            $modelItem->afterpaymentOnGoodsCost=$item['AfterpaymentOnGoodsCost'];
            $modelItem->packingNumber=$item['PackingNumber'];
            $modelItem->rejectionReason=$item['RejectedReason'];

            array_push($items,$modelItem);
        }
        return $items;*/

        return $documentsList->data;
    }
}
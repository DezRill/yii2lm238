<?php

use \yii\httpclient\Client;
use \yii\helpers\ArrayHelper;

function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function townRefToDescription($townRef, $key)
{
    $client = new Client();

    $townDescription = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'Address',
            'calledMethod' => 'getCities',
            'methodProperties' => ['Ref' => $townRef],
        ])->send();

    return ArrayHelper::getValue($townDescription->data, 'data.0.Description');
}

function departmentRefToDescription($departmentRef, $key)
{
    $client = new Client();

    $departmentDescription = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => ['Ref' => $departmentRef],
        ])->send();

    return ArrayHelper::getValue($departmentDescription->data, 'data.0.Description');
}

function getCounterparties($key)
{
    $counterpartiesArray = array();
    $client = new Client();

    $counterparties = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'Counterparty',
            'calledMethod' => 'getCounterparties',
            'methodProperties' => ['CounterpartyProperty' => 'Sender']
        ])->send();

    foreach ($counterparties->data['data'] as $item) {
        $counterpartiesArray += [$item['Ref'] => $item['Description']];
    }

    return $counterpartiesArray;
}

function getCounterpartyContactPerson($key, $ref)
{
    $client = new Client();
    $counterpartyContactPerson = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'Counterparty',
            'calledMethod' => 'getCounterpartyContactPersons',
            'methodProperties' => ['Ref' => $ref]
        ])->send();

    $counterpartyContactPersonArray = array();
    foreach ($counterpartyContactPerson->data['data'] as $item) {
        $counterpartyContactPersonArray += [$item['Ref'] => $item['Description']];
    }

    return $counterpartyContactPersonArray;
}

function getTestDocuments($apiKey)
{
    $client = new Client();

    $documents = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $apiKey,
            'modelName' => 'TrackingDocument',
            'calledMethod' => 'getStatusDocuments',
            'methodProperties' => [
                'Documents' => [
                    [
                        'DocumentNumber' => '20450376523172',
                        'Phone' => ''
                    ]
                ]
            ]
        ])->send();

    return ArrayHelper::getValue($documents->data, 'data.0.StatusCode');
}

/*function getCity($key, $ref)
{
    $client = new Client();

    $senderCity=$client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'Address',
            'calledMethod' => 'getCities',
            'methodProperties' => [
                'Ref' => $ref
            ]
        ])->send();

    return ArrayHelper::getValue($senderCity->data, 'data.0.Description');
}

function getAddress($key, $ref)
{
    $client = new Client();

    $senderAddress=$client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $key,
            'modelName' => 'Address',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $ref
            ]
        ])->send();

    //return ArrayHelper::getValue($senderAddress->data, 'data.0');
    return $senderAddress->data;
}*/
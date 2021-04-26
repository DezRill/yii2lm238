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

function getPhone($apiKey, $ref)
{
    $client = new Client();
    $counterpartyContactPerson = $client->createRequest()
        ->setFormat(Client::FORMAT_JSON)
        ->setUrl('https://api.novaposhta.ua/v2.0/json/')
        ->setData([
            'apiKey' => $apiKey,
            'modelName' => 'Counterparty',
            'calledMethod' => 'getCounterpartyContactPersons',
            'methodProperties' => ['Ref' => $ref]
        ])->send();

    $phone=ArrayHelper::getValue($counterpartyContactPerson->data, 'data.0.Phones');

    return $phone;
}
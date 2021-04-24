<?php

namespace app\assets;

use yii\web\AssetBundle;

class CargoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/';
    public $css = [
        'css/cargo/cargo.css',
    ];
    public $js = [
        'js/cargo/cargo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\kartik\slider\SliderAsset'
    ];
}
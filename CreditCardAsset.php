<?php

namespace andrewblake1\creditcard;

use Yii;
use yii\web\AssetBundle;

class CreditCardAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'andrewblake1\creditcard\JqueryPaymentAsset',
        'andrewblake1\creditcard\FontAwesomeAsset',
    ];

    public $sourcePath = '@andrewblake1/creditcard/assets';

    public $css = [
        'css/creditcard.css',
    ];

    public $js = [
        'js/creditcard.js',
    ];
}
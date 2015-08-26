<?php

namespace andrewblake1\creditcard;

use Yii;
use yii\web\AssetBundle;

class CreditCardAsset extends AssetBundle
{
    public $sourcePath = '@vendor/';

    public $css = [
         'andrewblake1/yii2-credit-card/assets/css/creditcard.css',
    ];

    public $js = [
        'bower/jquery.payment/lib/jquery.payment.js',
        'andrewblake1/yii2-credit-card/assets/js/jquery.creditcard.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
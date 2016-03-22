<?php

namespace havryliv\creditcard;

use Yii;
use yii\web\AssetBundle;

class CreditCardAsset extends AssetBundle
{
    public $sourcePath = '@vendor/';

    public $css = [
         'bower/font-awesome/css/font-awesome.css',
         'havryliv/yii2-credit-card/assets/css/creditcard.css',
    ];

    public $js = [
        'bower/jquery.payment/lib/jquery.payment.js',
        'havryliv/yii2-credit-card/assets/js/creditcard.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
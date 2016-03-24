<?php

namespace andrewblake1\creditcard;

use Yii;
use yii\web\AssetBundle;

class JqueryPaymentAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.payment/lib';

    public $js = [
        'jquery.payment.js',
    ];
}
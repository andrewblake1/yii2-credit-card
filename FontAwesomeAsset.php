<?php

namespace andrewblake1\creditcard;

use Yii;
use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome/css';

    public $css = [
        'font-awesome.min.css',
    ];
}
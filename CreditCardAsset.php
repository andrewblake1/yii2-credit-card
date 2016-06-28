<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license https://github.com/andrewblake1/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.1.1
 */
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
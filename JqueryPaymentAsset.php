<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license https://github.com/andrewblake1/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.1.0
 */
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
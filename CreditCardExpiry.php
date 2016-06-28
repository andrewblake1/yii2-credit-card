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
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Credit card expiry widget with client validation/masking for Yii2 framework configured to use client validation
 * courtesy of stripe as per https://github.com/stripe/jquery.payment and to work with yii.activeform.js.
 *
 * @author Andrew Blake <admin@newzealandfishing.com>
 */
class CreditCardExpiry extends InputWidget
{
    public $autocomplete = 'cc-expiry';

    public function registerAssets()
    {
        parent::registerAssets();
        $this->registerPlugin('ccExpiry');
    }

}
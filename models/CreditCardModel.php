<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.0.1
 */
namespace andrewblake1\creditcard\models;

use yii\base\Model;
use andrewblake1\creditcard\validators\CCNumberValidator;
use andrewblake1\creditcard\validators\CCExpiryValidator;
use andrewblake1\creditcard\validators\CCCVCodeValidator;
use Yii;

/**
 * Credit card model.
 *
 * @author Andrew Blake <admin@newzealandfishing.com>
 */
class CreditCardModel extends Model
{
    public $cardNumber;
    public $expiry;
    public $cvc;

    public function formName() {
        return 'CreditCard';
    }

    public function rules()
    {
        return [
            [['cardNumber', 'expiry', 'cvc'], 'required'],
            [['cardNumber'], CCNumberValidator::className()],
            [['expiry'], CCExpiryValidator::className()],
            [['cvc'], CCCVCodeValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cardNumber' => Yii::t('creditcard', 'Card number'),
            'expiry' => Yii::t('creditcard', 'Expiry'),
            'cvc' => Yii::t('creditcard', 'CV Code'),
        ];
    }
}

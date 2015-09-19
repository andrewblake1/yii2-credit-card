<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.0.2
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
    public $numberAttribute;

    public $expiryAttribute;

    public $cvcAttribute;

    public $dynamicAttributes = [];

    public function formName() {
        return 'BraintreeForm';
    }

    public function __get($name) {
        if (!isset($this->dynamicAttributes[$name])) {
            $this->dynamicAttributes[$name] = null;
        }

        return $this->dynamicAttributes[$name];
    }

    public function __set($name, $value) {
        $this->dynamicAttributes[$name] = $value;
    }

    public function rules()
    {
        return [
            [[$this->numberAttribute, $this->expiryAttribute, $this->cvcAttribute], 'required'],
            [[$this->numberAttribute], CCNumberValidator::className()],
            [[$this->expiryAttribute], CCExpiryValidator::className()],
            [[$this->cvcAttribute], CCCVCodeValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            $this->numberAttribute => Yii::t('creditcard', 'Card number'),
            $this->expiryAttribute => Yii::t('creditcard', 'Expiry'),
            $this->cvcAttribute => Yii::t('creditcard', 'CV Code'),
        ];
    }
}

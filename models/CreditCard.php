<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.1.1
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
class CreditCard extends Model
{
    public $numberAttribute = 'creditCard_number';

    public $expiryAttribute = 'creditCard_expirationDate';

    public $cvcAttribute = 'creditCard_cvv';

    private $_attributes = [];

    public function __get($name)
    {
        if (in_array($name, ['creditCard_number', 'creditCard_expirationDate', 'creditCard_cvv'])) {
            if (!isset($this->_attributes[$name])) {
                $this->_attributes[$name] = null;
            }

            return $this->_attributes[$name];
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, ['creditCard_number', 'creditCard_expirationDate', 'creditCard_cvv'])) {
            $this->_attributes[$name] = $value;
        }

        return parent::__set($name, $value);
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

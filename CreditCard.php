<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license https://github.com/andrewblake1/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.0.2
 */
namespace andrewblake1\creditcard;

use andrewblake1\creditcard\models\CreditCardModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Credit card form fields for Yii2 framework configured to use client validation courtesy of stripe as per
 * https://github.com/stripe/jquery.payment and to work with yii.activeform.js.
 *
 * Server side validation is considered irrelevant as the credit card processor/aggregator's service will perform
 * validation.
 *
 * Usage notes:
 * 1. Set autocomplete="on" within the form
 * 2. Best suited to yii\bootstrap\ActiveForm
 * 3. For simplicity each field that is added is required, haven't made this an option as typically if credit card
 *    forms are shown then they are required.
 * 4. Pass the ActiveForm object in the constructor
 *
 * Design consideration:
 * 1. Have used Widget as the base class because it provides access to view - otherwise Component would do.
 *
 * @author Andrew Blake <admin@newzealandfishing.com>
 */
class CreditCard extends Widget
{
    /** @var ActiveForm the bootstrap/ActiveForm object */
    public $form;

    /** @var string Credit card number attribute name */
    public $numberAttribute = 'creditCard_number';

    /** @var string Credit card expiry attribute name */
    public $expiryAttribute = 'creditCard_expirationDate';

    /** @var string Credit card cvc/cvv/ccv attribute name */
    public $cvcAttribute = 'creditCard_cvv';

    private $model;

    public function init()
    {
        parent::init();
        $this->model = new CreditCardModel([
            'numberAttribute' => $this->numberAttribute,
            'expiryAttribute' => $this->expiryAttribute,
            'cvcAttribute' => $this->cvcAttribute,
        ]);
        $this->checkConfig();
        $this->registerTranslations();
        CreditCardAsset::register($this->view);
    }

    public function registerTranslations()
    {
        Yii::setAlias("@creditcard", __DIR__);
        Yii::$app->i18n->translations['creditcard'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@creditcard/messages',
        ];
    }

    /**
     * Generate credit card number form field
     * @param array $fieldConfig any special config and overriding config for the form field
     * @return $this form field html
     */
    public function number($fieldConfig = [])
    {
        // default field configuration
        $fieldConfig = ArrayHelper::merge([
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lg fa-credit-card"></i></span>{input}</div>',
            'inputOptions' => [
                'type' => 'tel',
                'autocomplete' => 'cc-number',
                'placeholder' => Yii::t('creditcard', 'Card number'),
            ],
        ], $fieldConfig);
        // ensure id is correct and consistent with validation attribute in active form
        $fieldConfig['inputOptions']['id'] = Html::getInputId($this->model, $this->numberAttribute);

        // bind event handlers
        $this->view->registerJs("jQuery('#{$fieldConfig['inputOptions']['id']}').ccNumber();");

        // build the field
        return $this->form->field($this->model, $this->numberAttribute, $fieldConfig)->textInput();
    }

    /**
     * Generate credit card expiry form field
     * @param array $fieldConfig any special config and overriding config for the form field
     * @return $this form field html
     */
    public function expiry($fieldConfig = [])
    {
        // default field configuration
        $fieldConfig = ArrayHelper::merge([
            'inputOptions' => [
                'autocomplete' => 'cc-exp',
                'placeholder' => Yii::t('creditcard', 'MM / YY'),
            ],
        ], $fieldConfig);
        // ensure id is correct and consistent with validation attribute in active form
        $fieldConfig['inputOptions']['id'] = Html::getInputId($this->model, $this->expiryAttribute);

        // Mask credit card expiry using stripes https://github.com/stripe/jquery.payment
         $this->view->registerJs("jQuery('#{$fieldConfig['inputOptions']['id']}').payment('formatCardExpiry');");

        // build the field
        return $this->form->field($this->model, $this->expiryAttribute, $fieldConfig)->textInput();
    }

    /**
     * Generate credit card cvc form field
     * @param array $fieldConfig any special config and overriding config for the form field
     * @return $this form field html
     */
    public function cvc($fieldConfig = [])
    {
        // default field configuration
        $fieldConfig = ArrayHelper::merge([
            'inputOptions' => [
                'placeholder' => Yii::t('creditcard', 'CV code'),
            ],
        ], $fieldConfig);
        // ensure id is correct and consistent with validation attribute in active form
        $fieldConfig['inputOptions']['id'] = Html::getInputId($this->model, $this->cvcAttribute);

        // Mask credit card CVC/CVV/CSC (security verification code) using stripes https://github.com/stripe/jquery.payment
        $this->view->registerJs("jQuery('#{$fieldConfig['inputOptions']['id']}').payment('formatCardCVC');");

        // build the field
        return $this->form->field($this->model, $this->cvcAttribute, $fieldConfig)->textInput();
    }

    /**
     * Check the configuration is valid
     *
     * @throws InvalidConfigException
     */
    private function checkConfig()
    {
        /**
         * config checks
         */

        if (!$this->form) {
            throw new InvalidConfigException("The 'form' property must be defined and must be an instance of
                yii\widgets\ActiveForm");
        } elseif (!$this->form instanceof \yii\widgets\ActiveForm) {
            throw new InvalidConfigException("The 'form' property must be an instance of yii\widgets\ActiveForm");
        }
    }
}
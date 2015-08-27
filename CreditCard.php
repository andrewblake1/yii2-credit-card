<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license https://github.com/andrewblake1/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.0.0
 */
namespace andrewblake1\creditcard;

use andrewblake1\creditcard\validators\CCNumberValidator;
use andrewblake1\creditcard\validators\CCExpiryValidator;
use andrewblake1\creditcard\validators\CCCVCodeValidator;
use Yii;
use yii\base\DynamicModel;
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
    /**
     * @var ActiveForm the bootstrap/ActiveForm object.
     */
    public $form;

    /**
     * @var Model (optional) the model containing the credit card attributes to be rendered
     */
    public $model;

    /**
     * @var string the credit card number attribute within $model
     */
    public $numberAttribute = 'cardNumber';

    /**
     * @var string the credit card expiry attribute within $model
     */
    public $expiryAttribute = 'expiry';

    /**
     * @var string the credit card CVC/CSC/CVV attribute within $model
     */
    public $cvcAttribute = 'cvCode';

    public function init()
    {
        parent::init();
        $this->checkConfig();
        $this->registerTranslations();

        // if no model provided
        if (!$this->model) {
            // default model
            $this->model = new DynamicModel([
                $this->numberAttribute,
                $this->expiryAttribute,
                $this->cvcAttribute,
            ]);
            // required validator
            $this->model->addRule([
                $this->numberAttribute,
                $this->expiryAttribute,
                $this->cvcAttribute,
            ], 'required');
        }

        // add credit card number validator
        $this->model->addRule($this->numberAttribute, CCNumberValidator::className());
        // add credit card expiry validator
        $this->model->addRule($this->expiryAttribute, CCExpiryValidator::className());
        // add credit card cvc validator
        $this->model->addRule($this->cvcAttribute, CCCVCodeValidator::className());

        // register assets
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
                'id' => Html::getInputId($this->model, $this->numberAttribute),
                'type' => 'tel',
                'autocomplete' => 'cc-number',
                'placeholder' => Yii::t('creditcard', 'Card number'),
            ],
        ], $fieldConfig);

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
                'id' => Html::getInputId($this->model, $this->expiryAttribute),
                'autocomplete' => 'cc-exp',
                'placeholder' => Yii::t('creditcard', 'MM / YY'),
            ],
        ], $fieldConfig);

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
                'id' => Html::getInputId($this->model, $this->cvcAttribute),
                'placeholder' => Yii::t('creditcard', 'CV code'),
            ],
        ], $fieldConfig);

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

        if ($this->model) {
            if (!$this->model instanceof \yii\base\Model) {
                throw new InvalidConfigException("The 'model' property is optional but if set must be an instance of
                    yii\base\Model");
            }

            if (!$this->model->hasAttribute($this->cvcAttribute)) {
                throw new InvalidConfigException("The 'model' property is optional but if set then the 'numberAttribute'
                    property must be the name of an attribute that exists in the model");
            }

            if (!$this->model->hasAttribute($this->cvcAttribute)) {
                throw new InvalidConfigException("The 'model' property is optional but if set then the 'expiryAttribute'
                    property must be the name of an attribute that exists in the model");
            }

            if (!$this->model->hasAttribute($this->cvcAttribute)) {
                throw new InvalidConfigException("The 'model' property is optional but if set then the 'cvcAttribute'
                    property must be the name of an attribute that exists in the model");
            }
        }
    }
}
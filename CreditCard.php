<?php

namespace andrewblake1\creditcard;

use yii\helpers\Html;
use yii\base\Widget;


/**
 * Credit card form fields for Yii2 framework configured to use client validation from stripe as per
 * https://github.com/stripe/jquery.payment and to work wit
 *
 * Notes set autocomplete="on" within the form before echoing this widget into the form
 *
 * @author Andrew Blake
 */
class CreditCard extends Widget
{
    /**
     * @var ActiveForm the ActiveForm object.
     */
    public $form;

    /**
     * @var Model the model containing the credit card attributes to be rendered
     */
    public $model;

    /**
     * @var string|null the credit number attribute within the model or null if the field shouldn't be rendered
     */
    public $cardNumberAttribute;

    /**
     * @var string|null the expiry date attribute within the model or null if the field shouldn't be rendered
     */
    public $expiryAttribute;

    /**
     * @var string|null the cvc/cvv/csc attribute within the model or null if the field shouldn't be rendered
     */
    public $cvcAttribute;

    public function run()
    {
        $view = $this->getView();

        // register assets
        CreditCardAsset::register($view);

        // generate credit card form fields
        $html = $this->ccNumber($view);
        $html .= $this->ccExpiry($view);
        $html .= $this->ccCVC($view);

        return $html;
    }

    /**
     * Generate credit card number form field
     * @param $view
     * @return string
     */
    private function ccNumber($view)
    {
        if ($this->model->hasAttribute($this->expiryAttribute)) {
            $cardNumber = $this->form->field($this->model, $this->cardNumberAttribute)->textInput([
                'class' => 'cc-number',
                'type' => 'tel',
                'autocomplete' => 'cc-number',
            ]);
            $html = Html::tag('div', $cardNumber, ['id' => 'cc-num']);
            $view->registerJs('jQuery("#cc-num input").ccNumber();');
            return $html;
        }
    }

    /**
     * Generate credit card expiry form field
     * @param $view
     * @return string
     */
    private function ccExpiry($view)
    {
        if ($this->model->hasAttribute($this->expiryAttribute)) {
            $expiry = $this->form->field($this->model, $this->expiryAttribute)->textInput([
                'class' => 'cc-exp',
                'autocomplete' => 'cc-exp',
            ]);
            $view->registerJs('jQuery("#cc-exp input").ccExpiry();');
            return Html::tag('div', $expiry, ['id' => 'cc-exp']);
        }
    }

    /**
     * Generate credit card cvc form field
     * @param $view
     * @return string
     */
    private function ccCVC($view)
    {
        if ($this->model->hasAttribute($this->cvcAttribute)) {
            $cvc = $this->form->field($this->model, $this->cvcAttribute)->textInput([
                'class' => 'cc-exp',
            ]);
            $view->registerJs('jQuery("#cc-cvc input").ccCVC();');
            return Html::tag('div', $cvc, ['id' => 'cc-cvc']);
        }
    }
}
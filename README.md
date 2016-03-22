yii2-credit-card
======================

[![Latest Stable Version](https://poser.pugx.org/andrewblake1/yii2-credit-card/v/stable)](https://packagist.org/packages/andrewblake1/yii2-credit-card)
[![License](https://poser.pugx.org/andrewblake1/yii2-credit-card/license)](https://packagist.org/packages/andrewblake1/yii2-credit-card)

Yii2 Bootstrap 3 components, providing client validated and masked credit card number, expiry and cvc fields with credit card icon changing to match credit card type when detectable.

Uses client validation courtesy of Stripe (https://github.com/stripe/jquery.payment) and works with validation in ActiveForm.

### The future

1. Integrate first with Braintree and potentially Stripe e.g. any requirements to encode the fields when posting request etc.

2. Language translations

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/andrewblake1/yii2-credit-card/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install

```
$ php composer.phar require andrewblake1/yii2-credit-card "@dev"
```

or add

```
"andrewblake1/yii2-credit-card": "@dev"
```

to the `require` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.0.3. Refer the [CHANGE LOG](https://github.com/andrewblake1/yii2-credit-card/blob/master/CHANGE.md) for details.

## Usage in view

Note that the input names here have been chosen to fit work with the tuyakhov\braintree extension

```php
<?php
use yii\bootstrap\ActiveForm;
use andrewblake1\creditcard\CreditCardNumber;
use andrewblake1\creditcard\CreditCardExpiry;
use andrewblake1\creditcard\CreditCardCVCode;
?>

<?php $form = ActiveForm::begin() ?>
    <div class="container">
        <div id="card" class="row">
            <div class="col-xs-7">
                <?= $form->field($bookingForm, 'creditCard_number')->widget(CreditCardNumber::className(), ['name' => 'creditCard_number',]) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($bookingForm, 'creditCard_expirationDate')->widget(CreditCardExpiry::className(), ['name' => 'creditCard_expirationDate',]) ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($bookingForm, 'creditCard_cvv')->widget(CreditCardCVCode::className(), ['name' => 'creditCard_cvv',]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>
```
## License

**yii2-credit-card** is released under the MIT License. See the bundled `LICENSE.md` for details.

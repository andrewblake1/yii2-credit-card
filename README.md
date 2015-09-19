yii2-credit-card
======================

[![Latest Stable Version](https://poser.pugx.org/andrewblake1/yii2-credit-card/v/stable)](https://packagist.org/packages/andrewblake1/yii2-credit-card)
[![License](https://poser.pugx.org/andrewblake1/yii2-credit-card/license)](https://packagist.org/packages/andrewblake1/yii2-credit-card)

Yii2 Bootstrap 3 component, providing client validated and masked credit card number, expiry and cvc fields with credit card icon changing to match credit card type when detectable.

Uses client validation courtesy of Stripe (https://github.com/stripe/jquery.payment) and works with validation in ActiveForm.

Options

- **form** ActiveForm the bootstrap/ActiveForm object, *required*.

- **numberAttribute** string Credit card number attribute name, *defaults to 'creditCard_number'*.

- **expiryAttribute** string Credit card number expiry attribute name, *defaults to 'creditCard_expirationDate'*.

- **cvcAttribute** string Credit card cvc/cvv/ccv  attribute name, *defaults to 'creditCard_cvv'*.

In addition, the methods number(), expiry(), and cvc() accept an optional field configuration array as used by yii\bootstrap\ActiveForm::field.

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

> NOTE: The latest version of the module is v1.0.2. Refer the [CHANGE LOG](https://github.com/andrewblake1/yii2-credit-card/blob/master/CHANGE.md) for details.

## Usage in view

```php
<?php
use yii\bootstrap\ActiveForm;
use andrewblake1\creditcard\CreditCard;
?>

<?php $form = ActiveForm::begin() ?>
  <div class="container">
      <?php $creditCard = new CreditCard(['form' => $form]);?>
      <div class="row"><div class="col-xs-12"><?= $creditCard->number() ?></div></div>
      <div class="row"><div class="col-xs-12"><?= $creditCard->expiry() ?></div></div>
      <div class="row"><div class="col-xs-12"><?= $creditCard->cvc() ?></div></div>
  </div>
<?php ActiveForm::end() ?>
```
## License

**yii2-credit-card** is released under the MIT License. See the bundled `LICENSE.md` for details.

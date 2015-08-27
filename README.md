yii2-credit-card
======================

[![Latest Stable Version](https://poser.pugx.org/andrewblake1/yii2-credit-card/v/stable)](https://packagist.org/packages/andrewblake1/yii2-credit-card)
[![License](https://poser.pugx.org/andrewblake1/yii2-credit-card/license)](https://packagist.org/packages/andrewblake1/yii2-credit-card)

Credit card form fields for Yii2 framework and configured primarily for Bootstrap 3.

Uses client validation courtesy of Stripe (https://github.com/stripe/jquery.payment) and works with ActiveForm to dynamically change credit card icon as the user types a credit card number as well as masking input as the user types and validating on blur.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/andrewblake1/yii2-credit-card/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run (NB: no packagiest release yet - tomorrow)

```
$ php composer.phar require andrewblake1/yii2-credit-card "@dev"
```

or add

```
"andrewblake1/yii2-credit-card": "@dev"
```

to the `require` section of your `composer.json` file.


## Latest Release

> NOTE: The latest version of the module is v0.0.1. Refer the [CHANGE LOG](https://github.com/andrewblake1/yii2-credit-card/blob/master/CHANGE.md) for details.

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

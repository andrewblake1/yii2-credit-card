version 1.1.1
=============
**Date:** 29-Jun-2016

1. Added new "submit" option that when set to false will not add the name attribute into the input.
2. Refactored to extend form new InputWidget class.

version 1.1.0
=============
**Date:** 17-Jun-2016

1. BC: Changed CreditCardModel for just CreditCard. Re-factored a little within here.
2. Remove default placeholder from each of the fields as can be added in in standard way within Options.
3. Modified code so that if addon is empty for each field then isn't added.

version 1.0.3
=============
**Date:** 23-Mar-2016

1. Added classes CreditCardCVCode, CreditCardExpiry, and CreditCardNumber. These extend from \kartik\base\InputWidget and
   are used as per README documentation.

version 1.0.2
=============
**Date:** 29-Aug-2015

1. Added numberAttribute, expiryAttribute, and cvcAttribute public properties in order to use with tuyakhov\yii2-braintree extension

version 1.0.1
=============
**Date:** 29-Aug-2015

1. Swapped DynamicModel for Model
2. Removed options for providing model and custom naming of attributes

version 1.0.0
=============
**Date:** 27-Aug-2015

Initial release. The following features are included in this release:

1. Yii2 Bootstrap 3 component, providing client validated and masked credit card number, expiry and cvc code fields with credit card icon changing to match credit card type when detectable.

2. Uses client validation courtesy of Stripe (https://github.com/stripe/jquery.payment) and works with validation in ActiveForm to show errors and success

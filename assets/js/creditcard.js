/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.1.0
 */
(function($) {

    /**
     * plugins
     */

    /**
     * Mask credit card number and change credit card icon when credit card type can be detected
     *
     * Using stripes https://github.com/stripe/jquery.payment and font-awesome
     *
     * @returns {$.fn}
     */
    $.fn.ccNumber = function () {
        var $this = $(this);

        // format and mask as the user types
        $this.payment("formatCardNumber")
            // set credit card icon as type
            // TODO: should be on change but working around issue https://github.com/stripe/jquery.payment/issues/159
            .on("keyup paste", function () {
                var ccNumber = $this.val();
                var type = $.payment.cardType(ccNumber);
                var icon;
                switch (type) {
                    case 'visa':
                        icon = 'cc-visa';
                        break;
                    case 'mastercard':
                        icon = 'cc-mastercard';
                        break;
                    case 'amex':
                        icon = 'cc-amex';
                        break;
                    case 'dinersclub':
                        icon = 'cc-diners-club';
                        break;
                    case 'discover':
                        icon = 'cc-discover';
                        break;
                    case 'jcb':
                        icon = 'cc-jcb';
                        break;
                    case 'unionpay':
                    case 'visaelectron':
                    case 'maestro':
                    case 'forbrugsforeningen':
                    case 'dankort':
                    default:
                        icon = 'credit-card';
                }
                $this.parent().find('.fa').removeClass().addClass('fa fa-lg fa-' + icon);
            });

        return this;
    }

    /**
     * Mask credit card expiry date
     *
     * Using stripes https://github.com/stripe/jquery.payment
     *
     * @returns {$.fn}
     */
    $.fn.ccExpiry = function () {
        $(this).payment("formatCardExpiry");
        return this;
    }

    /**
     * Mask credit card cvc
     *
     * Using stripes https://github.com/stripe/jquery.payment
     *
     * @returns {$.fn}
     */
    $.fn.ccCVC = function () {
        $(this).payment("formatCardCVC");
        return this;
    }

}(jQuery));

(function($) {

    /**
     * plugins
     */

    $.fn.ccNumber = function () {
        var $this = $(this);

        $this.payment("formatCardNumber").on("blur", function () {
            var ccNumber = $this.val()
            $.payment.validateCardNumber(ccNumber);
        });

        return this;
    }

    $.fn.ccExpiry = function () {
        var $this = $(this);

        $this.payment("formatCardExpiry").on("blur", function () {
            var expiry = $this.payment('cardExpiryVal');
            $.payment.validateCardExpiry(expiry.month, expiry.year);
        });

        return this;
    }

    $.fn.ccCVC = function () {
        var $this = $(this);

        $this.payment("formatCardCVC").on("blur", function () {
            var cvc = $this.val();
            var type = $.payment.cardType($('#cc-num input'));
            $.payment.validateCardCVC(cvc, type);
        });

        return this;
    }

}(jQuery));

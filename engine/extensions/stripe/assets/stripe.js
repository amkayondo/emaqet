$(document).ready(function () {

    // Create a Stripe client.
    var stripe = Stripe($('#stripe-form-wrapper').data('pk'));

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Create an instance of the card Element.
    var card = elements.create('card');

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if($('#stripe-form-wrapper').is(':visible')) {
            if (event.error) {
                $(displayError).parents('.form-group').addClass('has-error');
                displayError.textContent = event.error.message;
            } else {
                $(displayError).parents('.form-group').removeClass('has-error');
                displayError.textContent = '';
            }
        }
        return false;
    });

    // Handle form submission.
    $('#package-form').on('submit', function (e) {
        if($('#stripe-form-wrapper').is(':visible')) {
            var $form = $(this);
            if ($form.data('running')) {
                return false;
            }
            $form.data('running', true);

            if (!$form.find('input[name="stripeToken"]').val()) {
                stripe.createToken(card).then(function (result) {
                    $form.data('running', false);
                    if (result.error) {
                        $('body').removeClass('please-wait');
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        $(elements).parents('.form-group').addClass('has-error');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
                return false;
            }

            return true;
        }
    });


    $(document).on('change','#payment_method_stripe', function(){
        $('#payment-details-block > div').hide();
        $('#stripe-form-wrapper').show();
    });
});

/**
 *
 * @param token
 */
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('package-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
    return false;
}
"use strict";

$(document).ready(function () {
	var paymentType = jQuery('#payment_type').val();
	if (paymentType == 15) {
		$('.stripe-payment-method-div').show('slow');
	} else {
		$('.stripe-payment-method-div').hide('slow');
	}
});

var stripe = Stripe(stripeKey);
var elements = stripe.elements();
var card = elements.create('card');
card.mount('#card-element');

jQuery(document).on('change', '#payment_type', function () {
	var paymentType = jQuery('#payment_type').val();
	if (paymentType == 15) {
		$('.stripe-payment-method-div').show('slow');
	} else {
		$('.stripe-payment-method-div').hide('slow');
	}
});

var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
	event.preventDefault();
	var paymentType = jQuery('#payment_type').val();
	if (paymentType == 15) {
		stripe.createToken(card).then(function (result) {
			if (result.error) {
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
			} else {
				stripeTokenHandler(result.token);
			}
		});
	} else if (paymentType == 16) {
		var total_amount = totalAmount *100;
		var site_name = siteName;
		var site_logo = siteLogo;
		var currency = currencyName;
		var razorpay_key = razorpayKey;
		var options = {
			"key": razorpay_key, // Enter the Key ID generated from the Dashboard
			"amount": total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
			"currency": currency,
			"name": site_name,
			"image": site_logo,
			"handler": function (response) {
                razPayTokenHandler(response.razorpay_payment_id);
                console.log(response);
			},
			"prefill": {
				"name": "",
				"email": "",
				"contact": ""
			},
			"notes": {
				"address": ""
			},
			"theme": {
				"color": "#F37254"
			}
		};
		var rzp1 = new Razorpay(options);
		rzp1.open();


	} else {
		form.submit();
	}
});

function stripeTokenHandler(token) {
	var form = document.getElementById('payment-form');
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'stripeToken');
	hiddenInput.setAttribute('value', token.id);
	form.appendChild(hiddenInput);
	form.submit();
}

function razPayTokenHandler(razorpay_payment_id) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'razorpay_payment_id');
    hiddenInput.setAttribute('value',razorpay_payment_id);
    form.appendChild(hiddenInput);
    form.submit();
}

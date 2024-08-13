
$(function () {
    $('#number').intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        dropdownContainer: document.body,
        formatOnDisplay: true,
        initialCountry: country_code_name ? country_code_name : 'gb',
        placeholderNumberType: "MOBILE",
        preferredCountries: ['us','gb','in'],
        separateDialCode: true
    });
});


$("#number").on('countrychange', function(e, countryData) {
    var code = $("#number").intlTelInput("getSelectedCountryData").dialCode;
    $("#code").val(code);
    var code_name = $("#number").intlTelInput("getSelectedCountryData").iso2;
    $("#code_name").val(code_name);
});

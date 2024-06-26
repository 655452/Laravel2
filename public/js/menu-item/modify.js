"use strict";

function variationItemDesign() {
    menu_item_variation_count++;
    var markup = '';
    markup += '<tr>';
        markup += '<td>';
            markup += '<input type="text" name="variation['+menu_item_variation_count+'][name]" placeholder="Name" name="name" class="form-control form-control-sm">';
        markup +='</td>';
        markup +='<td>';
            markup += '<input type="number" step=".01" name="variation['+menu_item_variation_count+'][price]" placeholder="Price" class="form-control form-control-sm change-productprice">';
        markup += '</td>';
        markup +='<td>';
        markup +='<input type="number" step=".01" name="variation['+menu_item_variation_count+'][discount_price]" placeholder="Discount Price" class="form-control form-control-sm change-productdiscountprice">';
        markup +='</td>';
        markup +='<td>';
            markup += '<button class="btn btn-danger btn-sm removeBtn">'
                markup += '<i class="fa fa-trash"></i>';
            markup += '</button>';
        markup += '</td>';
    markup += '</tr>';
    return markup;
}

function optionItemDesign() {
    menu_item_option_count++;
    var markup = '';
    markup += '<tr>';
        markup += '<td>';
            markup += '<input type="text" name="option['+menu_item_option_count+'][name]" placeholder="Name" class="form-control form-control-sm">';
        markup +='</td>';
        markup +='<td>';
            markup += '<input type="number" step=".01" name="option['+menu_item_option_count+'][price]" placeholder="Price" class="form-control form-control-sm change-productprice">';
        markup += '</td>';
        markup +='<td>';
            markup += '<button class="btn btn-danger btn-sm removeBtn">'
                markup += '<i class="fa fa-trash"></i>';
            markup += '</button>';
        markup += '</td>';
    markup += '</tr>';
    return markup;
}

$('#variation-add').on('click', function(event) {
    event.preventDefault();
    $('#variationTbody').append(variationItemDesign());
});

$('#option-add').on('click', function(event) {
    event.preventDefault();
    $('#optionTbody').append(optionItemDesign());
});

$(document).on('click','.removeBtn', function(event) {
    event.preventDefault();
    $(this).parent().parent().remove()
});

$(document).on('keyup', '.change-productprice', function() {
    var productPrice =  toFixedVal($(this).val());
    $(this).val(productPrice);

    if(dotAndNumber(productPrice)) {
        if(productPrice.length > 12) {
            productPrice = lenChecker(productPrice, 12);
            $(this).val(productPrice);
        }

        if(productPrice != '' && productPrice != null) {
            if(floatChecker(productPrice)) {
                if(productPrice.length > 12) {
                    productPrice = lenChecker(productPrice, 12);
                    $(this).val(productPrice);
                }
            }
        }
    } else {
        var productPrice = parseSentenceForNumber(toFixedVal($(this).val()));
        $(this).val(productPrice);
    }
});

$(document).on('keyup', '.change-productdiscountprice', function() {
    var productDiscountPrice =  toFixedVal($(this).val());
    $(this).val(productDiscountPrice);

    if(dotAndNumber(productDiscountPrice)) {
        if(productDiscountPrice.length > 12) {
            productDiscountPrice = lenChecker(productDiscountPrice, 12);
            $(this).val(productDiscountPrice);
        }

        if(productDiscountPrice != '' && productDiscountPrice != null) {
            if(floatChecker(productDiscountPrice)) {
                if(productDiscountPrice.length > 12) {
                    productDiscountPrice = lenChecker(productDiscountPrice, 12);
                    $(this).val(productDiscountPrice);
                }
            }
        }
    } else {
        var productDiscountPrice = parseSentenceForNumber(toFixedVal($(this).val()));
        $(this).val(productDiscountPrice);
    }
});

$(document).on('keyup', '.change-productquantity', function() {
    var productQuantity = $(this).val();
    var productQuantity = Math.trunc(productQuantity);
    $(this).val(productQuantity);
});

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function floatChecker(value) {
    var val = value;
    if(isNumeric(val)) {
        return true;
    } else {
        return false;
    }
}

function dotAndNumber(data) {
    var retArray = [];
    var fltFlag = true;
    if(data.length > 0) {
        for(var i = 0; i <= (data.length-1); i++) {
            if(i == 0 && data.charAt(i) == '.') {
                fltFlag = false;
                retArray.push(true);
            } else {
                if(data.charAt(i) == '.' && fltFlag == true) {
                    retArray.push(true);
                    fltFlag = false;
                } else {
                    if(isNumeric(data.charAt(i))) {
                        retArray.push(true);
                    } else {
                        retArray.push(false);
                    }
                }

            }
        }
    }

    if(jQuery.inArray(false, retArray) ==  -1) {
        return true;
    }
    return false;
}

function toFixedVal(x) {
  if (Math.abs(x) < 1.0) {
    var e = parseFloat(x.toString().split('e-')[1]);
    if (e) {
        x *= Math.pow(10,e-1);
        x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
    }
  } else {
    var e = parseFloat(x.toString().split('+')[1]);
    if (e > 20) {
        e -= 20;
        x /= Math.pow(10,e);
        x += (new Array(e+1)).join('0');
    }
  }
  return x;
}

function parseSentenceForNumber(sentence) {
    var matches = sentence.replace(/,/g, '').match(/(\+|-)?((\d+(\.\d+)?)|(\.\d+))/);
    return matches && matches[0] || null;
}

function lenChecker(data, len) {
    var retdata = 0;
    var lencount = 0;
    data = toFixedVal(data);
    if(data.length > len) {
        lencount = (data.length - len);
        data = data.toString();
        data = data.slice(0, -lencount);
        retdata = parseFloat(data);
    } else {
        retdata = parseFloat(data);
    }

    return toFixedVal(retdata);
}

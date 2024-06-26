// For header sticky when scroll page
$(window).on('scroll', function() {
    if(this.scrollY > 0) $('.header.sticky').addClass('active');
    else $('.header.sticky').removeClass('active');
})



// For restaurant menu sticky when scroll
$(window).on('scroll', function() {
    if(this.scrollY > 400) $('.rest-menu-wrapper').addClass('active');
    else $('.rest-menu-wrapper').removeClass('active');
})


// For language name and flag dropdown selection
function dropdownSelection(dropdown, selection) {
    let selectElement = document?.querySelectorAll(dropdown);
    let toggleValue = false;

    selectElement?.forEach((selectItem) => {

        let buttonElement = selectItem?.firstElementChild;
        let paperElement = selectItem?.lastElementChild;

        let currImg = buttonElement?.querySelector("img");
        let currSpan = buttonElement?.querySelector("span");

        document?.addEventListener("click", function(event) {

            if(!selectItem?.contains(event?.target)) {
                toggleValue = false;
                buttonElement?.classList?.remove("active");
                paperElement?.classList?.remove("active");
            }
            else {
                if(!buttonElement) {
                    buttonElement?.classList?.remove("active");
                    paperElement?.classList?.remove("active");
                }
                else {
                    toggleValue = !toggleValue

                    if(toggleValue) {
                        buttonElement?.classList?.add("active");
                        paperElement?.classList?.add("active");
                    }
                    else {
                        buttonElement?.classList?.remove("active");
                        paperElement?.classList?.remove("active");
                    }
                }
            }
        })

        if(selection) {
            for(let i = 0; i < paperElement?.children?.length; i++) {
                paperElement?.children[i]?.addEventListener("click", function() {

                    let selectSrc = this?.querySelector("img")?.getAttribute("src");
                    let selectText = this?.querySelector("span")?.textContent;

                    currImg.src = selectSrc
                    currSpan.innerText = selectText
                })
            }
        }
    })
}
dropdownSelection(".header-auth", false);
dropdownSelection(".header-account", false);
dropdownSelection(".header-selection", true);


// For group content single active
function groupActive(targetElement, toggleElement) {
    $(targetElement).children().on('click', function() {
        $(targetElement).children().removeClass(toggleElement);
        $(this).addClass(toggleElement);
    })
}

groupActive('.checkout-fieldset', 'active');
groupActive('.booking-modal-time ul', 'selected');
groupActive('.address-modal-label-navs', 'active');
groupActive('.filter-swiper .swiper-wrapper', 'active');
groupActive('.rest-swiper .swiper-wrapper', 'swiper-slide-active');




// For restaurant details page cart sidebar functionality
$(function() {
    if( window.matchMedia("(max-width: 991px)").matches) {
        $('.cart-sidebar').removeClass('active');
    }

    $('.header-cart').on('click', function() {
        $('.rest-col').addClass('col-lg-8');
        $('.cart-sidebar').addClass('active');
        $('body').addClass('cart-flow');
    })

    $('.cart-close').on('click', function() {
        $('.rest-col').removeClass('col-lg-8');
        $('.cart-sidebar').removeClass('active');
        $('body').removeClass('cart-flow');
    })
})

function printDiv(divID) {
    var oldPage = document.body.innerHTML;
    var divElements = document.getElementById(divID).innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";

    window.print();
    document.body.innerHTML = oldPage;
    window.location.reload();
}


// For food cart counter
$(function() {
    $('.cart-counter').each(function(index, item) {
        // For increment
        $(item).children('.cart-counter-plus').on('click', function() {
            $(item).children('.cart-counter-value').val(function(currItem, curValue) {
                return ++curValue;
            })
        })

        // For decrement
        $(item).children('.cart-counter-minus').on('click', function() { 
            $(item).children('.cart-counter-value').val(function(currItem, curValue) {
                if(curValue > 1) return --curValue;
                else return 1
            })
        })
    })
})


// For booking modal time slot selection
$(function(){
    $('.booking-modal-group').each(function(index, item) {
        $(item).children('.booking-modal-select').on('click', function() {
            $(this.parentElement).children('.booking-modal-option').toggleClass('active');
            $(this).toggleClass('active');
        })

        $(item).children('.booking-modal-option').children('button').on('click', function() {
            $(this.parentElement).removeClass('active');
            $(this).parents(".booking-modal-group").children('.booking-modal-select').removeClass('active');
        })
    })
});


// For restaurant list filter hide and show when mobile device
$(function() {
    let toggleValue = false;

    $('.settings-btn').on('click', function() {
        toggleValue = !toggleValue

        if(toggleValue) {
            $(this.parentElement).addClass('active');
            $(this).children('span').text(function(currindex, currtext) {
                return currtext === 'show menu' && 'hide menu'
            });
        }
        else {
            $(this.parentElement).removeClass('active');
            $(this).children('span').text(function(currindex, currtext) {
                return currtext === 'hide menu' && 'show menu'
            });
        }
    })
})


$(function() {
    $('.tracked').last().addClass('active');
})


// Content slide down or collapse
function singleSlideDown(dataAttr, attrName, toggleClass) {
    const btnElement = document?.querySelector(dataAttr);
    const tabElement = document?.querySelector(btnElement?.dataset[attrName]);

    document?.addEventListener("click", function (event) {

        if (btnElement && tabElement) {
            if (!btnElement?.contains(event?.target)) {
                if (!tabElement?.contains(event?.target)) {
                    btnElement?.classList?.remove(toggleClass);
                    tabElement.style.height = "0px";
                }
            }
            else {
                btnElement?.classList?.add(toggleClass);
                tabElement.style.height = `${tabElement?.scrollHeight}px`;
            }
        }
    })
}
singleSlideDown("[data-collapse]", "collapse", "active");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    console.log("ready");
    // Disable form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            $('[data-numeric]').payment('restrictNumeric');
            $('.ccnum').payment('formatCardNumber');
            $('.ccexp').payment('formatCardExpiry');
            $('.cccvc').payment('formatCardCVC');
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            $('#ccnum').keyup(function () {
                var cardType = $.payment.cardType($('.ccnum').val());
                $("#ccbrand").html(cardType);
            });
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
})();

function displayRadioValue() {
            var ele = document.getElementsByName('card');
            for(i = 0; i < ele.length; i++) {
                if(ele[i].checked)
                document.getElementById("ccnum").value
                        = ele[i].value;
            }
        }





//CREDIT CARD VALIDATION TO INCLUDE INTO THE BOOTSTRAP
//$(function ($) {
//    $('[data-numeric]').payment('restrictNumeric');
//    $('.ccnum').payment('formatCardNumber');
//    $('.ccexp').payment('formatCardExpiry');
//    $('.cccvc').payment('formatCardCVC');
//    $.fn.toggleInputError = function (erred) {
//        this.parent('.form-group').toggleClass('has-error', erred);
//        return this;
//    };
//    $('form').submit(function (e) {
//        e.preventDefault();
//        var cardType = $.payment.cardType($('.ccnum').val());
//        $('.ccnum').toggleInputError(!$.payment.validateCardNumber($('.ccnum').val()));
//        $('.ccexp').toggleInputError(!$.payment.validateCardExpiry($('.ccexp').payment('cardExpiryVal')));
//        $('.cccvc').toggleInputError(!$.payment.validateCardCVC($('.cccvc').val(), cardType));
//////        $('.ccbrand').text(cardType);
////        $("#ccbrand").html(cardType);
//        $('.validation').removeClass('text-danger text-success');
//        $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');
////    });
//    $('#ccnum').keyup(function(){
//        var cardType = $.payment.cardType($('.ccnum').val());
//        $("#ccbrand").html(cardType);
//    });
//});
//});

//    $("#btnSubmit").on("click", function() {
//        var $this           = $("#btnSubmit"); //submit button selector using ID
//        var $caption        = $this.html();// We store the html content of the submit button
//        var form            = "#form"; //defined the #form ID
//        var formData        = $(form).serializeArray(); //serialize the form into array
//        var route           = $(form).attr('action'); //get the route using attribute action
//
//        // Ajax config
//        $.ajax({
//            type: "POST", //we are using POST method to submit the data to the server side
//            url: route, // get the route value
//            data: formData, // our serialized array data for server side
//            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
//                $this.attr('disabled', true).html("Processing...");
//            },
//            success: function (response) {//once the request successfully process to the server side it will return result here
//                $this.attr('disabled', false).html($caption);
//                // We will display the result using alert
//                alert(response);
//            },
//            error: function (XMLHttpRequest, textStatus, errorThrown) {
//                // You can put something here if there is an error from submitted request
//            }
//        });
//    });


//});

//function checkfleids(){
//    // Example starter JavaScript for disabling form submissions if there are invalid fields
//    (() => {
//        'use strict';
//        
//    const forms = document.querySelectorAll('.needs-validation');
//    // Loop over them and prevent submission
//    Array.prototype.slice.call(forms).forEach((form) => {
//            form.addEventListener('submit', (event) => {
//            if (!form.checkValidity()) {
//                event.preventDefault();
//                event.stopPropagation();
//                }
//            form.classList.add('was-validated');
//            }, false);
//        });
//    })();
//}
//


//(function() {
//  'use strict';
//  window.addEventListener('load', function() {
//    // Fetch all the forms we want to apply custom Bootstrap validation styles to
//    var forms = document.getElementsByClassName('needs-validation');
//    // Loop over them and prevent submission
//    var validation = Array.prototype.filter.call(forms, function(form) {
//      form.addEventListener('submit', function(event) {
//        if (form.checkValidity() === false) {
//          event.preventDefault();
//          event.stopPropagation();
//        }
//        form.classList.add('was-validated');
//      }, false);
//    });
//  }, false);

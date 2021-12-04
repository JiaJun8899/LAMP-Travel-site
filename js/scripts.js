$(document).ready(function () {
    console.log("ready");
    checktotal();
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
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
            var splitArray = ele[i].value.split(",");
            var ccnum = splitArray[0];
            var ccname = splitArray[2];
            var ccexp = splitArray[1];
        }

        document.getElementById("ccnum").value
                = ccnum;
        document.getElementById("ccname").value
                = ccname;
        document.getElementById("ccexp").value
                = ccexp;
        console.log(ccnum, "name: ", ccname, "exp: ", ccexp);
    }

}

function clearRadioinfo() {
    var ele = document.getElementsByName("card");
    for (var i = 0; i < ele.length; i++) {
        ele[i].checked = false;
    }

    document.getElementById("ccnum").value
            = "";
    document.getElementById("ccname").value
            = "";
    document.getElementById("ccexp").value
            = "";
}


function checktotal() {
    var total = document.getElementById("totalamt").value;
    console.log(total);
    if (total == 0) {
        alert("Your Cart is empty, You shouldn't be here!");
        window.location.replace("http://35.187.229.58/project/tour_packages.php");
    }
}
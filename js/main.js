$(document).ready(function () {
    console.log("Ready!");
    $("#email").on("input", validatemail);
    $("#pwd").on("input", validatepwd);
    $("#conpwd").on("input", checkSame);
    activateMenu();
});

function activateMenu() {
    var current_page_URL = location.href;
    $(".navbar-nav a").each(function () {
        var target_URL = $(this).prop("href");
        if (target_URL === current_page_URL) {
            $('nav a').parents('li, ul').removeClass('active');
            $(this).parent('li').addClass('active');
            return false;
        }
    });
}
//Validation for register page
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatemail() {
    const $result = $("#emailerror");
    const $email = $("#email").val();
    $result.text("");
    if (validateEmail($email)) {
        $result.text("");
    } else {
        $result.text($email + " is not a valid email");
        $result.css("color", "red");
    }
    if($email == ""){
        $result.text("");
    }
    return false;
}

function validatePwd(pwd) {
    var paswd = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
    return paswd.test(pwd);
}

function validatepwd() {
    const $pwdresult = $("#pwderror");
    const $pwd = $("#pwd").val();
    $pwdresult.text("");
    if (validatePwd($pwd)) {
        $pwdresult.text("Password is valid");
        $pwdresult.css("color", "green");
        $submit.attr("disabled", false);
    } else {
        $pwdresult.text("Password is not valid");
        $pwdresult.css("color", "red");
        $submit.attr("disabled", true);
    }
    console.log($pwd);
    return false;
}
function checkSame() {
    const $inputpwd = $("#pwd").val();
    const $conpwd = $("#conpwd").val();
    const $conpwdresult = $("#conpwderror");
    const $submit = $("#regibtn");
    if ($inputpwd === $conpwd) {
        $conpwdresult.text("Passwords are same");
        $conpwdresult.css("color", "green");
        $submit.attr("disabled", false);
    } else {
        $conpwdresult.text("Please input the same password!");
        $conpwdresult.css("color", "red");
        $submit.attr("disabled", true);
    }
}
//Register page validation ends here
//Tour packages JS functions
// package pop up menu
function popUp(buttonObj){
    // get data from button parents
    // classes = country, city, price, short-description, long-description, image-link
    var id, country, city, price, shortDescription, longDescription, imageLink;
    
    // get parent div that button is contained in
    var parentDiv = buttonObj.parentNode;
    
    // get content in parentDiv with class names
    var children = parentDiv.childNodes;
    for(var i = 0; i < children.length; i++){
        if (hasClass(children[i], "country"))
            country = children[i].innerHTML;
        else if (hasClass(children[i], "city"))
            city = children[i].innerHTML;
        else if (hasClass(children[i], "price"))
            price = children[i].innerHTML;
        else if (hasClass(children[i], "short-description"))
            shortDescription = children[i].innerHTML;
        else if (hasClass(children[i], "long-description"))
            longDescription = children[i].innerHTML;
        else if (hasClass(children[i], "image-link"))
            imageLink = children[i].innerHTML;
    }
    
    id = buttonObj.id;
    
    // place content in popup elements
    document.getElementById("popup-country").innerHTML = country;
    document.getElementById("ccountry").value = country;
    document.getElementById("popup-city").innerHTML = city;
    document.getElementById("popup-price").innerHTML = "Price: " + price;
    document.getElementById("cprice").value = price;
    document.getElementById("popup-thumbnail").src = imageLink;
    document.getElementById("popup-thumbnail").alt = city;
    document.getElementById("popup-long-description").innerHTML = longDescription;    
    document.getElementById("package_id").value = "" + id;
}

function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className+ ' ') > -1;
}

// quantity function
function quantity_change(button_val)
{
    var valueInt = parseInt(document.getElementById("quantity").value, 10);
    
    if (button_val === 0 && valueInt > 1)
    {
        valueInt -= 1;
    }
    else if (button_val === 1 && valueInt < 100)
    {
        valueInt += 1;
    }
    document.getElementById("quantity").value = "" + valueInt;
}
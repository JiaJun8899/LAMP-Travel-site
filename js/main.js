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
    } else {
        $pwdresult.text("Password is not valid");
        $pwdresult.css("color", "red");
    }
    console.log($pwd);
    return false;
}
function checkSame() {
    const $inputpwd = $("#pwd").val();
    const $conpwd = $("#conpwd").val();
    const $conpwdresult = $("#conpwderror");
    if ($inputpwd === $conpwd) {
        $conpwdresult.text("Passwords are same");
        $conpwdresult.css("color", "green");
    } else {
        $conpwdresult.text("Please input the same password!");
        $conpwdresult.css("color", "red");
    }
}
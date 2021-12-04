$(document).ready(function(){
    console.log("Ready!");
    
    // ajax for database
    // on submit...
    // does not work still
//    $('#package-form').submit(function(e){
//        e.preventDefault();
//        $("#error").hide();
//        
//        // date required
//        var date = $("#date").val();
//        if(date == ""){
//            $("#error").fadeIn().text("date required.");
//            $("#date").focus();
//            return false;
//        }
//        // package_id required
//        var package_id = $("#package_id").val();
//        if(package_id == ""){
//            $("#error").fadeIn().text("package_id required");
//            $("#package_id").focus();
//            return false;
//        }
//        // quantity number required
//        var quantity = $("#quantity").val();
//        if(quantity == ""){
//            $("#error").fadeIn().text("quantity required");
//            $("#quantity").focus();
//            return false;
//        }
//        
//        console.log("content" + date + package_id + quantity);
//        
//        // ajax
//        $.ajax({
//            type: "post",
//            url: "process_add_to_cart.php",
//            data: {date: date, package_id: package_id, quantity: quantity}, // get all form field value in serialize form
//            datatype: "json",
//            cache: false,
//            beforeSend: function(data) {
//                console.log('ABOUT TO SEND' + data);
//            },
//            success: function(){
//                console.log("sent to php");
//                //$("#ajax-form").fadeOut();
//            }
//            ,error: function(){ 
//                alert("error!!!!");
//            }
//        });
//    });
}); 

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

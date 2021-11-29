$(document).ready(function(){
    console.log("Ready!");
    
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
    document.getElementById("popup-city").innerHTML = city;
    document.getElementById("popup-price").innerHTML = "Price: " + price;
    document.getElementById("popup-thumbnail").src = imageLink;
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

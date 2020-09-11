var items = {};
var totalPrice = 0;
var itemNumber = 0;
$(document).ready( function () {
    window.addEventListener( "pageshow", function ( event ) {
      var historyTraversal = event.persisted ||  ( typeof window.performance != "undefined" &&  window.performance.navigation.type === 2 );
      if ( historyTraversal ) {
        // Handle page restore.
        window.location.reload();
      }
    });
    
    $('#exp_data').inputmask({alias: 'datetime', inputFormat: 'mm/yy'});
    $("form[name='cardinfo_form']").validate({
        // Specify validation rules
        rules: {
            cardholder_name: {
              required: true,
            },
            pan_number: {
              required: true,
              digits: true,
              maxlength:16,
              minlength:16
            },
            cvv: {
              required: true,
              digits: true,
              maxlength:4,
              minlength:3
            },
            exp_data: {
              required: true,
              date: true
            }
        },
        // Specify validation error messages
        messages: {
          cardholder_name: "Please insert card holder name",
          pan_number: "Please insert valid pan number",
          cvv: "Please insert valid CVC",
          exp_data: "Please give card expiry date"
        },
        errorElement : 'div',
        submitHandler: function(form) {
          form.submit();
        }
    });
    $(".add_product").click(function(){
        var product_id = $(this).data("id");
        var price = $(this).data("price");
        updateQuantity(product_id, price);
    });
});

function openNav() {
    var width = "30%";
    if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        width = "100%";
    }
    else if( /iPad/i.test(navigator.userAgent) ) {
        width = "50%";
    }
    document.getElementById("mySidenav").style.width = width;
    $("#cart_open").css("display", "none");
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    $("#cart_open").css("display", "block");
}

function updateCart(items){
    $.ajax({
        url: "/update-cart",
        type: 'GET',
        data: {
            items : items
        },
        dataType: 'json'
    })
    .done(function(response){
        $("#cart_div").empty();    
        var cartHtml = "";
        if(response.success){
            if(response.data.length>0){
                $.each(response.data, function(i, item) {
                    cartHtml += '<li class="list-group-item">'+
                                    '<div class="row no-gutters d-flex align-items-center">'+
                                        '<div class="col-1 text-center" id="quantity_"'+item.id+'>'+
                                            item.quantity+
                                        '</div>'+
                                        '<div class="col-1 text-center">'+
                                            '<i class="fas fa-chevron-up cursor-pointer" onclick="updateQuantity(\''+item.id+'\',\''+item.price+'\',\'increase\');"></i>'+
                                            '<br>'+
                                            '<i class="fas fa-chevron-down cursor-pointer" onclick="updateQuantity(\''+item.id+'\',\''+item.price+'\',\'decrease\');"></i>'+
                                        '</div>'+
                                        '<div class="col-6 text-center">'+
                                            item.name+
                                        '</div>'+
                                        '<div class="col-3 text-center">'+
                                            item.itemTotalPrice+
                                        '</div>'+
                                        '<div class="col-1 text-center cursor-pointer" onclick="removeItem(\''+item.id+'\',\''+item.price+'\');">'+
                                            'x'+
                                        '</div>'+
                                    '</div>'+
                                '</li>';
                });
                $("#place_order").removeClass('disbale-event');
            }
            else{
                cartHtml += '<li class="list-group-item">'+
                                    '<div class="row no-gutters d-flex align-items-center">'+
                                        response.message+
                                    '</div>'+
                                '</li>';
                $("#buy").hide();
                $("#place_order").addClass('disbale-event');
            }
        }
        else{
            cartHtml = response.message;
        }

        const element = document.querySelector('#cart_open');
        if(element){
            element.classList.add('animated', 'bounce');
            setTimeout(function() {
                element.classList.remove('bounce');
            }, 1000);    
        }
        $("#cart_div").append(cartHtml);
    });  
}


function updateQuantity(id, price, type="increase"){
    if(type == "increase"){
        if (items[id] === undefined || items[id].length == 0) {
            items[id] = 1;
            itemNumber++;
            totalPrice = parseFloat(totalPrice) + parseFloat(price);
        }
        else if(items[id]<2){
            items[id]++;
            itemNumber++;
            totalPrice = parseFloat(totalPrice) + parseFloat(price);
        }
        else{
            alert("You cannot select more than 2 of same product.");
            return false;
        }    
    }
    else if(type=="decrease"){
        if(items[id] == 1){
            alert("You have to buy atleast one.");
            return false;
        }
        else{
            items[id]--;
            itemNumber--;
            totalPrice = parseFloat(totalPrice) - parseFloat(price);
        }
    }
    
    $("#items").text(itemNumber+" ");
    $("#amount").text(totalPrice+" ");
    $("#items_cart").text(itemNumber+" ");
    $("#amount_cart").text(totalPrice+" ");
    updateCart(items);
}


function removeItem(id, price){
    totalPrice = totalPrice - parseFloat(items[id]*price);
    itemNumber = itemNumber - items[id]; 
    delete items[id];
    $("#items").text(itemNumber+" ");
    $("#amount").text(totalPrice+" ");
    $("#items_cart").text(itemNumber+" ");
    $("#amount_cart").text(totalPrice+" ");
    updateCart(items);
}
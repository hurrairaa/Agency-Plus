(function($) {
    "use strict";
    
jQuery(document).ready(function($) {


// ============== add to cart js start =======================//

    $(".cart-link").click(function() {
        let cartUrl = $(this).attr('data-href');
        console.log(cartUrl);
        let cartItemCount = $('.cart-amount').val();
        if(cartItemCount > 1){
            $.get(cartUrl+',,,'+cartItemCount,function(res){

                if(res.message){
                    toastr["success"](res.message);
                    $('.cart-amount').val(1);
                }else{
                    toastr["error"](res.error);
                 $('.cart-amount').val(1);
                }  
            })
        }else{
            $.get(cartUrl,function(res){
                if(res.message){
                    toastr["success"](res.message);
                }else{
                    toastr["error"](res.error);
                }
            })
        }
    });

// ============== add to cart js end =======================//

//=============== cart update js start ==========================//

    $(document).on('click','#cartUpdate',function(){
        let cartqty = [];
        let cartprice = [];
        let cartproduct = [];
        let cartUpdateUrl = $(this).attr('data-href');
        
        $(".cart_qty").each(function() {
            cartqty.push($(this).val());
        })
        
        $(".cart_price span").each(function() {
            cartprice.push(parseFloat($(this).text()));
        });
        
        $(".product_id").each(function() {
            cartproduct.push($(this).val());
        });
        
        let formData = new FormData();
        let i = 0;
        for(i=0; i<cartqty.length; i++) {
            formData.append('qty[]', cartqty[i]);
            formData.append('cartprice[]', cartprice[i]);
            formData.append('product_id[]', cartproduct[i]);
        }
        
        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });
        
        $.ajax({
                   type: "POST",
                   url: cartUpdateUrl,
                   data: formData,
                   processData: false,
                   contentType:false,
                   success: function(data)
                   {
                       console.log(data);
                    if(data.message){
                        let cartPriceUpdate = [];
                        $(".cart_price span").each(function() {
                            cartPriceUpdate.push(parseFloat($(this).text()));
                        });
        
                        $(".sub-total span").each(function(index,val) {
                            $(this).text(cartPriceUpdate[index] * cartqty[index]);
                        });

                        $('.cart-total-view').text(data.total);
        
                        toastr["success"](data.message);
                        if(data.count){
                            $('.cart-item-view').text(data.count);
                            $('.cart-total-view').text((position == 'left' ? symbol + " " : '') + data.total + (position == 'right' ? " " + symbol : ''));
                        }
                    }else{
                        toastr["error"](data.error);
                    }
                        
                }
            });
        })
        
        
//================= cart update js end ==========================//

// ================ cart item remove js start =======================//

    $(document).on('click','.item-remove',function(){
        let removeItem = $(this).attr('rel');
        let removeItemUrl = $(this).attr('data-href');
        $.get(removeItemUrl,function(res){
            if(res.message){
                toastr["success"](res.message);
                if(res.count == 0){
                    $(".total-item-info").remove();
                    $(".cart-table").remove();
                    $(".cart-middle").remove();
                    $('.table-outer').html( `
                        <div class="bg-light py-5 text-center">
                            <h3 class="text-uppercase">Cart is empty!</h3>
                        </div>`
                    );
                }
                $('.cart-item-view').text(res.count);
                $('.cart-total-view').text((position == 'left' ? symbol + " " : '') + res.total + (position == 'right' ? " " + symbol : ''));
                $('.remove'+removeItem).remove(); 
            }else{
                toastr["success"](res.error);
            }
          
        });
      
    });

    
// ================ cart item remove js start =======================//

       
});



$(document).on('click','.addclick',function(){
    let orderamount = $('.cart-amount').val();
    $('#order_click_with_qty').val(orderamount);
})
$(document).on('click','.subclick',function(){
    let orderamount = $('.cart-amount').val();
    $('#order_click_with_qty').val(orderamount);
})

}(jQuery));
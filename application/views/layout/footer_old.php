<a id="button"></a>
<section class="fruits_store">

  <div class="shipping-outer section">

    <div class="container">

      <div class="shipping-inner row">

        <div class="heading col-12 col-sm-3 text-center text-lg-left">

          <h2>Why choose us?</h2>

        </div>

        <div class="subtitle-part subtitle-part1 col-12 mb-3 col-sm-3  text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="far fa-clock"></i></div>

              <div class="subtitile1">On time delivery</div>

              <!-- <div class="subtitile2">15% back if not able</div> -->

            </div>

          </div>

        </div>

        <div class="subtitle-part subtitle-part2 mb-3 col-12 col-sm-3 text-center text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="fas fa-truck"></i></div>

              <div class="subtitile1">Same Day Delivery</div>

              <!-- <div class="subtitile2">Order over $ 200</div> -->

            </div>

          </div>

        </div>

        <div class="subtitle-part subtitle-part3 col-12 col-sm-3 mb-3 text-center text-lg-left">

          <div class="subtitle-part-inner text-left">

            <div class="subtitile">

              <div class="subtitle-part-image"><i class="fas fa-check-circle"></i></div>

              <div class="subtitile1">Quality assurance</div>

              <!-- <div class="subtitile2">You can trust us</div> -->

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>
<!-- Footer -->
<footer>
  <div class="container">
    <div class="row footer py-5">

      <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

       <a href="<?=base_url();?>">
        <img src="<?=base_url('assets/')?>images/logo.png" alt="logo" class="img-fluid" width="150" height="80">
      </a>
      <p class="footer-text">
        Gowisekart is an online grocery market currently operating in Delhi and Delhi NCR with a vision to provide
        fresh organic fruits and vegetables at the lowest market price to the consumers.

      </p>
      <img src="<?=base_url('assets/')?>images/weaccept.png" alt="logo" class="img-fluid" width="180" height="50">
      <!--  <img src="assets/weaccept.png" alt="" width="180"> -->
      <strong><h5>Download Our App</h5></strong>
      <a href="https://play.google.com/store/apps/details?id=com.gowisekart" target="blank">
        <img src="<?=base_url('assets/gp.png')?>" alt="play-store" class="img-fluid" width="150">
      </a>


    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <ul>
        <strong><h5> MOST POPULAR CATEGORIES </h5></strong>
        <hr>
        <?php
        $parentCategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y' limit 6"); 
        if(!empty($parentCategory)){
          foreach($parentCategory as $category){

           ?>
           <li>
             <a href="<?=base_url('home/category_products/'.$category->categoryID)?>"><?=$category->title?></a>
           </li>

         <?php }}?>

         <li>
           <a href="<?=base_url('home/product_search')?>">More</a>
         </li>
       </ul>
     </div>

     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <ul>
       <strong><h5>CUSTOMER SERVICES</h5></strong>
       <hr>
       <li>
         <a href="<?=base_url('/')?>">Home</a>
       </li>
       
       <li>
        <a href="<?=base_url('home/about')?>">About</a>
      </li>
      <li>
       <a href="<?=base_url('home/contactus')?>">Contact</a>

     </li>
     <li>
       <a href="<?=base_url('home/faqs')?>">FAQ</a>
     </li>

     <li>
      <a href="<?=base_url('home/terms_condition')?>">Terms & Conditions</a>
    </li>

    <li>
     <a href="<?=base_url('home/privacy_policy')?>">Privacy Policy</a>
   </li>



 </ul>
</div>

</div>




</div> 
</div>
</footer>
<section class="copyrights"> <div class="copyrights-container">  <span>© <?=date('Y')?>All rights reserved. GowiseKart</span></div> </section>



<script src="<?=base_url('assets/js/');?>bootstrap.bundle.js" ></script>
<script src="<?=base_url('assets/js/');?>bootstrap.min.js"></script>
<script src="<?=base_url('assets/js/');?>bootstrap.js"></script>
<script src="<?= base_url('assets/js/');?>owl.carousel.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<!-- 
<script>

$(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({
      items : 10, //10 items above 1000px browser width
      itemsDesktop : [1000,5], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
  });
});

 

</script> -->

</body>
</html>

<script>
  function get_cityID(e) {
    e.preventDefault();
    let cityID  = $('#cityID').val();
    console.log(cityID);
    if (cityID != '')
    {

      $.ajax({
        url: '<?php echo base_url(); ?>/home/city',
        type: 'POST',
        data: {cityID:cityID},
        success: function (response) {
          if(response!=''){
            location.reload();
          }
        }
      });
    }
  }
</script>

<script>
  function user_login(e) {



    e.preventDefault();

//alert('ok');

let user_mobile = $('#user_mobile').val();
//alert(user_mobile);



let phone_validator = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;



if (phone_validator.test(user_mobile) && user_mobile.length == 10) {



  $.ajax({



    url : "<?=base_url("login/index")?>",



    data : "user_mobile="+user_mobile,



    method : "post",



    success : function (res) {



     console.log(res);



     if (res){

                //console.log("if");

                $('#user_mobile').val('');



                $('#login_error').html('');



                $('#login_modal').modal('hide');



                $('#login_otp_modal').modal('show');
                 //$('#register_otp_modal').modal('show');



                 $('#login_otp').val('');



               } 



               else{
                console.log("else");







                $('#login_error').html('! Your Entered Mobile Number is not registered with us. Please Enter Correct Mobile Number.');



                $('#login_modal').modal('hide');



                $('#register_modal').modal('show');



                $('#login_error').html('');



                $('#user_mobile').val('');



                $('#login_otp').val('');



                $('#login_error').html('');



              }



            }



          });



}else {

  console.log("invalid");

  $('#login_error').html('! Please input a valid mobile number.');



}



}

function user_register_info(e) {



  e.preventDefault();



  let name = $('#register_name').val();



  let mobile = $('#register_mobile').val();
  let user_city = $('#user_city').val();

  let referral_code = $('#referral_code').val();



  let phone_validator = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;



  let email_validator = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;



  if (name != "" && mobile != '')



  {



    if (phone_validator.test(mobile) && mobile.length == 10) {











     let data = "name="+name+"&mobile="+mobile+"&user_city="+user_city+"&referral_code="+referral_code;



     $.ajax({



      url:'<?=base_url("login/register_user")?>',



      data : data,



      method : 'POST',



      success : function (res) {
                    //console.log(res);



                    let response = JSON.parse(res);



                    if (response['result'] == 'success'){
                      console.log('success');



                      $('#register_modal').modal('toggle');



                      $('#register_otp_modal').modal('show');



                    } else {
                      console.log('success');



                      let error = '! '+response['msg'];



                      $('#register_error').html(error);



                    }



                  }



                });



   }else {



    $('#register_error').html('! Please input a valid mobile number.');



  }



}else {



  $('#register_error').html('! Please Fill All the Fields');



}



}


function register_otp_submit(e){



  e.preventDefault();
//console.log('otp');



let otp = $('#register_otp').val();
console.log(otp);



if (otp.length == 4)



{



  $.ajax({



    url : "<?=base_url("login/validate_register_otp")?>",



    data : "otp="+otp,



    method : "post",



    success : function (res) {
         //console.log(res);


         let response = JSON.parse(res);



         if (response['result'] == 'success'){



          $('#register_otp').val('');



          $('#register_otp_modal').modal('toggle');



          window.location.href = "<?=base_url("home")?>";



          /*document.location.reload();*/



        } else {



          let error = '! '+response['msg'];



          $('#register_otp_error').html(error);



        }



      }



    });



}else {



  $('#register_otp_error').html('! Please input valid otp.');



}



}

function otp_submit(e) {



  e.preventDefault();



  let otp = $('#login_otp').val();



  if (otp.length == 4)



  {



    $.ajax({



      url : "<?=base_url("login/validate_otp")?>",



      data : "otp="+otp,



      method : "post",



      success : function (res) {



        if (res == 'success'){



         $('#otp_error').val('');



         $('#login_otp').val('');



         $('#login_otp_modal').modal('toggle');



         $('#otp_error').val('');



         window.location.href = "<?=base_url("home")?>";



         /* document.location.reload();*/



       } else {



        $('#otp_error').html('! Your Entered OTP is incorrect.');



        $('#otp_error').val('');



        $('#login_otp').val('');



      }



    }



  });



  }else {



    $('#otp_error').html('! Please input valid otp.');



    $('#otp_error').val('');



    $('#login_otp').val('');



  }



}

function logout_user(e) {

  e.preventDefault();

  window.location.assign("<?=base_url("login/logout")?>");

}

</script> 
<script>


  function add_to_cart_type(productID,variantID,e,type){
   var qty = $('#get_qty'+productID).val();
   var maxQty =  $('#get_qty'+productID).attr('max');
   if(type==0){
    if(qty==1){
      return false;
    }else{
      qty--;

      ALERT(qty);
      $('#get_qty'+productID).val(qty);  
    } 
  }
  if (type == 1) {
    if(qty==maxQty){
     alert("you can't add more quantity");
     return false;
   }else{
    qty++;
    ALERT(qty);
    
    $('#get_qty'+productID).val(qty); 
  }
}

}


function add_to_cart(productID,variantID,e){
  var qty = $('#get_qty'+productID).val();
  console.log(qty);
  $.ajax({

    url : "<?php echo site_url('home/add_to_cart');?>",

    method : "POST",

    data : { productID: productID, variantID: variantID, qty: qty},

    success: function(data){
      var new_data = JSON.parse(data);
      if(new_data == 0){
        alert('Please Login');
        $('#get_qty'+productID).val(1);
      }
      if(new_data[1]>=1){
        alert('successfully added');
        // $('#add_cart_html'+productID).html('<a href="<?=base_url('home/shopping_cart')?>">GO TO CART</a>');
        $('#get_qty'+productID).val(new_data[1]);
        $('#total_cart_value').text(new_data[0]);
        $('#cart_value1').text(new_data[0]);
      }
      
    }

  });
}

</script>

<script>

  $('.variant_change').change(function () {
    var variant_id = ($('option:selected', this).val());
    var productID = $(this).attr("productID");
    var userID = $(this).attr("get_user");
    var clickfun = $(".change_argument").attr("onclick");
    var funname = clickfun.substring(0, clickfun.indexOf("("));

    var clickfun1 = $(".change_argument_new").attr("onclick");
    var funname1 = clickfun1.substring(0, clickfun1.indexOf("("));

    $.ajax({
      url: '<?php echo base_url(); ?>/home/get_product_qty_cart_new',
      type: 'POST',
      data: {
       userID: userID,
       productID: productID,
       variantID: variant_id
     },
     success: function (data) {
      let variant_data = JSON.parse(data);
      if(variant_data.qty==0){
        variant_data.qty=1;
      }
      $('#get_qty'+productID).val(variant_data.qty);
      $('#set_Price'+productID).text(variant_data.price);
      $('#set_retailPrice'+productID).text(variant_data.retail_price);
      
    }
  });

    $(".change_argument").attr("onclick", funname + "(" + productID + "," + variant_id + "," +
      "event," + 0 + ")");
    $(".change_argument1").attr("onclick", funname + "(" + productID + "," + variant_id + "," +
      "event," + 1 + ")");
    $(".change_argument_new").attr("onclick", funname1 + "(" + productID + "," + variant_id + "," +
      "event)");


         //$("#id").attr("onclick","new_function_name()");

       });
     </script>



     <script>
      function wcqib_refresh_quantity_increments() {
        jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
          var c = jQuery(b);
          c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
        })
      }
      String.prototype.getDecimals || (String.prototype.getDecimals = function() {
        var a = this,
        b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
      }), jQuery(document).ready(function() {
        wcqib_refresh_quantity_increments()
      }), jQuery(document).on("updated_wc_div", function() {
        wcqib_refresh_quantity_increments()
      }), jQuery(document).on("click", ".plus, .minus", function() {
        var a = jQuery(this).closest(".quantity").find(".qty"),
        b = parseFloat(a.val()),
        c = parseFloat(a.attr("max")),
        d = parseFloat(a.attr("min")),
        e = a.attr("step");
        b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
      });
    </script>

    <script type="text/javascript">
      (function() {

        function addSeparator(nStr) {
          nStr += '';
          var x = nStr.split('.');
          var x1 = x[0];
          var x2 = x.length > 1 ? '.' + x[1] : '';
          var rgx = /(\d+)(\d{3})/;
          while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
          }
          return x1 + x2;
        }

        function rangeInputChangeEventHandler(e){
          var rangeGroup = $(this).attr('name'),
          minBtn = $(this).parent().children('.min'),
          maxBtn = $(this).parent().children('.max'),
          range_min = $(this).parent().children('.range_min'),
          range_max = $(this).parent().children('.range_max'),
                // range_min = $('.range_min').attr('data-name');
                // range_max = $('.range_max').attr('data-name');

                minVal = parseInt($(minBtn).val()),
                maxVal = parseInt($(maxBtn).val()),
                origin = $(this).context.className;

                if(origin === 'min' && minVal > maxVal-5){
                  $(minBtn).val(maxVal-5);
                }
                var minVal = parseInt($(minBtn).val());
                $(range_min).html(addSeparator(minVal*1000));


                if(origin === 'max' && maxVal-5 < minVal){
                  $(maxBtn).val(5+ minVal);
                }
                var maxVal = parseInt($(maxBtn).val());
                $(range_max).html(addSeparator(maxVal*1000));
              }

              $('input[type="range"]').on( 'input', rangeInputChangeEventHandler);
            })();
          </script>
          <script type="text/javascript">
            $('input[type="range"]').change(function(){
              var min = $(".range_min").html();
              var max = $(".range_max").html();
              var selectedCategories = "";
              var selectedBrands = "";
              var amount = 0;
              var type = "";
              var urlPrefix   = '<?php echo site_url('home/product_search?'); ?>'
              var urlSuffix = "";
              var search_key = '<?php echo $search_key; ?>';
              $('.categories:checked').each(function() {
                (selectedCategories === "") ? selectedCategories = $(this).attr('value') : selectedCategories = selectedCategories + "--" + $(this).attr('value');
              });
              urlSuffix = "select_category="+selectedCategories+"&select_brand="+selectedBrands+"&min_price="+min+"&max_price="+max+"&search_key="+search_key+"&dis_amt="+amount+"&dis_type="+type;
              window.location.replace(urlPrefix+urlSuffix);

            });

            function filter(elem,amount=0,type='') {
              var urlPrefix   = '<?php echo site_url('home/product_search?'); ?>'
              var urlSuffix = "";
              var selectedCategories = "";
              var selectedBrands = "";
              var min = $(".range_min").html();
              var max = $(".range_max").html();
              var search_key = '<?php echo $search_key; ?>';

              $('.categories:checked').each(function() {
                (selectedCategories === "") ? selectedCategories = $(this).attr('value') : selectedCategories = selectedCategories + "--" + $(this).attr('value');
              });
              $('.brands:checked').each(function() {
                (selectedBrands === "") ? selectedBrands = $(this).attr('value') : selectedBrands = selectedBrands + "--" + $(this).attr('value');
              });

              urlSuffix = "select_brand="+selectedBrands+"&select_category="+selectedCategories+"&min_price="+min+"&max_price="+max+"&search_key="+search_key+"&dis_amt="+amount+"&dis_type="+type;
              window.location.replace(urlPrefix+urlSuffix);

            }
            function filter_discount(elem,amount=0,type='') {
              var urlPrefix   = '<?php echo site_url('home/product_search?'); ?>'
              var urlSuffix = "";
              var selectedCategories = "";
              var selectedBrands = "";
              var min = $(".range_min").html();
              var max = $(".range_max").html();
              var search_key = '<?php echo $search_key; ?>';
              var disc_min = $('input[name=discount]:checked').attr("data-min");
              var disc_max = $('input[name=discount]:checked').attr("data-max");



              $('.categories:checked').each(function() {
                (selectedCategories === "") ? selectedCategories = $(this).attr('value') : selectedCategories = selectedCategories + "--" + $(this).attr('value');
              });
              $('.brands:checked').each(function() {
                (selectedBrands === "") ? selectedBrands = $(this).attr('value') : selectedBrands = selectedBrands + "--" + $(this).attr('value');
              });


              urlSuffix = "select_brand="+selectedBrands+"&select_category="+selectedCategories+"&min_price="+min+"&max_price="+max+"&search_key="+search_key+"&disc_min="+disc_min+"&disc_max="+disc_max;
              window.location.replace(urlPrefix+urlSuffix);

            }

            $('.accordion__header').click(function(e) {
              e.preventDefault();
              var currentIsActive = $(this).hasClass('is-active');
              $(this).parent('.accordion').find('> *').removeClass('is-active');
              if(currentIsActive != 1) {
                $(this).addClass('is-active');
                $(this).next('.accordion__body').addClass('is-active');
              }
            });
          </script>
          <script type="text/javascript">
/*$("#pincode_button").click(function(){
var pincode = $('#pincode').val();
 alert(pincode);
if(pincode ==''){
return false;
}

$.ajax({
url: '<?php echo base_url(); ?>/home/city_pincode',
type: 'POST',
data: {pincode:pincode},
success: function (response) {
var resp = JSON.parse(response);
if(resp.status  == 'true'){

location.reload();
}
else {
   $('#pincode_error').text(response.message);
}
}
});
});
*/
 /*function set_pin(e) {
       e.preventDefault();
       let pincode = $('#pincode').val();
       let data = "pincode="+pincode;

           $.ajax({
               url:"<?=base_url("home/pin")?>",
               method : "post",
               data : data,

               success : function (res) {
                    let response =JSON.parse(this.res);
                    if(response.result == 'success'){
                      alert("tgfvhg");
                      window.location.reload();
                   }else{
                       $('#pincode_error').text(response.msg);
                   }

               }
           });
         }*/
       </script>


       <script type="text/javascript">
        function minus_count(cartId,max_qty){
          var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
          var qty = $('#manage_qty'+cartId).val();
          if(qty > max_qty){
            alert('You cant add more than that');
            return false;
          }
          $.ajax({

            url:'<?=base_url("home/minus_cart_qty")?>',

            data:"cartId="+cartId+"&qty="+qty,

            dataType:"HTML",
            method : 'POST',
            success : function (res) {
             var res1 = JSON.parse(res);
             if(res1.status){
              get_cart(user_id);
            }
          }

        });

        }

        function plus_count(cartId,max_qty){
          var user_id = '<?php echo $this->session->userdata('loginUserID')?>';
          var qty = $('#manage_qty'+cartId).val();
          if(qty >= max_qty){
            alert('You cant add more than that');
            return false;
          }
          $.ajax({

            url:'<?=base_url("home/plus_cart_qty")?>',

            data:"cartId="+cartId+"&qty="+qty+"&max_qty="+max_qty,

            dataType:"HTML",
            method : 'POST',
            success : function (res) {
             var res1 = JSON.parse(res);
             if(res1.status){
              get_cart(user_id);
            }
          }

        });
        }
      </script>

      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>

        $("#tags").keyup(function(){  

          var search_key = $('#tags').val();

          if(search_key!=''){
            $.ajax({

              url:'<?=base_url("home/search_pro")?>',

              data:"search_key="+search_key,

              dataType:"JSON",
              method : 'POST',
              success : function (res) {

                var availableTags = res;
                $( "#tags" ).autocomplete({
                  source: availableTags
                });
              }

            });

          }






        });  






        







      </script>
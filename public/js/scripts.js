// ajax sort
$('#sort').on('change',function(e){
  console.log(e);

  var sort = e.target.value;
  $('#spanSort').empty();

  $.get('/ajax-sortproducts?sort=' +  sort, function(data){
      $('.productsAjax').empty();
      $.each(data,function(index,productsObj){
      $('.productsAjax').append('<div class="col-md-3"><div class="thumbnail"> <a href="store/viewproduct/'+productsObj.id +'"> <div class="caption clearfix"> <h4>' + productsObj.title +
        '</h4><div id="viewproductdetailed"> <button class="btn btn-info btn-xs modalproduct" >View Product</button></div></div></a><img src="img/products/' + productsObj.image+
        '" class="img-responsive image"><div id="authchecked"><form action="store/cart/" method="post"><input type="hidden" name="_token" value="'+token +
        '"><input type="hidden" name="product" value="'+productsObj.id+
        '"> <input type="hidden" name="price" value="'+productsObj.price+
        '"><input type="hidden" name="amount" value="1"> <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> </form> </div><h4> '+productsObj.title+
        '</h4> <p>'+productsObj.price+'</p> ');
       $('.productsAjax').find('.thumbnail').hover(
            function(){
                $(this).find('.caption').fadeIn(250); //.fadeIn(250)
            },
            function(){
                $(this).find('.caption').fadeOut(250); //.fadeOut(205)
            }
        ); 
             

      });

      
  });
  

});

/* ajax sort by subcategory
$('#sortSub').on('change',function(e){
  console.log(e);
  var id = catId;
  var sort = e.target.value;
 
 $.ajax({
  url:url,
  method:get,
  data:
 });
  

});
*/



// ajax load search

$('#keyword').on('keyup', function(){
    var value = $(this).val();
    console.log(value);
       $('.productsAjax').empty();

      $.ajax({
        type:'get',
        url : urlSearch,
        data :{'keyword':value },
        success:function(data){
                 $('.productsAjax').html(data);
          $('.productsAjax').find('.thumbnail').hover(
            function(){
                $(this).find('.caption').fadeIn(250); //.fadeIn(250)
            },
            function(){
                $(this).find('.caption').fadeOut(250); //.fadeOut(205)
            }
              ); 
                   

           }
        });
  });

// price slider


    // Listen for 'change' event, so this triggers when the user clicks on the checkboxes labels
    $('input[name="brands[]"]').on('change', function (e) {
       var brands = new Array(); // reset 


        $('input[name="brands[]"]:checked').each(function()
        {
             brands.push($(this).val());
              console.log(brands.push($(this).val()));
            
             if(this.checked){

                 $.ajax({
                          type: "GET",
                          url:urlBrands,
                          data: {'brands':brands },
                          success: function(data){
                              $('.productsAjax').html(data).delay( 8000 );
                                
                                   $('.productsAjax').find('.thumbnail').hover(
                                    function(){
                                        $(this).find('.caption').fadeIn(250); //.fadeIn(250)
                                    },
                                    function(){
                                        $(this).find('.caption').fadeOut(250); //.fadeOut(205)
                                    }
                                      ); 
                          }
                           
                 });

             }else{
            
             }
  

});


});



$(document).ready(function () {


  var outputSpan = $('#spanOutput');
  var sliderDiv = $('#slider');

   sliderDiv.slider({ range: true, 
    min: 100,
     max: 70000,
      values: [500, 40000], 
    slide: function (event, ui) {
     outputSpan.html(ui.values[0] + ' - ' + ui.values[1] );
      } ,
    stop: function (event, ui) {


       var min = ui.values[0];
        var max = ui.values[1];
        
       console.log(min+'-'+max);

       $.ajax({
            type: "GET",
            url:urlPrice,
            data: {'min_price':min ,'max_price':max },
            success: function(data){
                $('.productsAjax').html(data);
                $('.productsAjax').find('.thumbnail').hover(
            function(){
                $(this).find('.caption').fadeIn(250); //.fadeIn(250)
            },
            function(){
                $(this).find('.caption').fadeOut(250); //.fadeOut(205)
            }
              ); 
           
            }

        });
       
    $('#min_price').val(ui.values[0]);
    $('#max_price').val(ui.values[1]); }
     });
     outputSpan.html(sliderDiv.slider('values', 0) + 
      ' - ' + sliderDiv.slider('values', 1) );
      $('#min_price').val(sliderDiv.slider('values', 0)); 
      $('#max_price').val(sliderDiv.slider('values', 1));


    //var brands = [];

    // Listen for 'change' event, so this triggers when the user clicks on the checkboxes labels
    $('input[name="brands[]"]').on('change', function (e) {
       $('.productsAjax').empty();
        e.preventDefault();
       var brands = new Array(); // reset 


        $('input[name="brands[]"]:checked').each(function()
        {
             brands.push($(this).val());
              console.log(brands.push($(this).val()));
            
             if(this.checked){
                var outputSpan = $('#spanOutput');
                var sliderDiv = $('#slider');

             sliderDiv.slider({ range: true, 
              min: 100,
               max: 70000,
                values: [500, 40000], 
              slide: function (event, ui) {
               outputSpan.html(ui.values[0] + ' - ' + ui.values[1] );
                } ,
              stop: function (event, ui) {


                   var min = ui.values[0];
                  var max = ui.values[1];
                  
                 console.log(min+'-'+max);

               
              $('#min_price').val(ui.values[0]);
              $('#max_price').val(ui.values[1]); 

                 // checkbox is checked -> do something
                        $.ajax({
                          type: "GET",
                          url:urlBrands,
                          data: {'brands':brands ,'min_price':min , 'max_price':max },
                          success: function(data){
                              $('.productsAjax').html(data);
                                   $('.productsAjax').find('.thumbnail').hover(
                                    function(){
                                        $(this).find('.caption').fadeIn(250); //.fadeIn(250)
                                    },
                                    function(){
                                        $(this).find('.caption').fadeOut(250); //.fadeOut(205)
                                    }
                                      );
                              }
                           
                          });
              } 
      
          });

      }
               });
               outputSpan.html(sliderDiv.slider('values', 0) + 
                ' - ' + sliderDiv.slider('values', 1) );
                $('#min_price').val(sliderDiv.slider('values', 0)); 
                $('#max_price').val(sliderDiv.slider('values', 1));

      

    });

});


// hover product
$( document ).ready(function() {
		    $("[rel='tooltip']").tooltip();    
		 
		    $('.thumbnail').hover(
		        function(){
		            $(this).find('.caption').fadeIn(250); //.fadeIn(250)
		        },
		        function(){
		            $(this).find('.caption').fadeOut(250); //.fadeOut(205)
		        }
		    ); 
		});
//hover navigation
	$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeIn(440);
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeOut(2);
            $(this).toggleClass('open');       
        }
    );
});

//hide session
  $(document).ready(function () {
    //hide a div after 4 seconds
    setTimeout( "$('#divSession').hide();",4000 );
     
});


// ajax category
 var postCategoryElement=null;
 console.log(postCatId);
$('.category').find('.editCat').on('click',function(event){
  event.preventDefault();

 postCategoryElement = event.target.parentNode.parentNode.childNodes[1];
  var postCategory = postCategoryElement.textContent;
  postCatId =0;

  postCatId = $('.catid').val();

  //var categoryTrim =  postCategory.trim();
  $('#category').val(postCategory);
  $('#editCatModal').modal(); 
});

// modal save category
$('#modalsave-category').on('click' , function(){

  $.ajax({
      method:'POST',
      url: url,
         
      data:{ name: $('#category').val() , postCatId: postCatId, _token:token}
  })
  .done(function (msg){
    $(postCategoryElement).text(msg['new_category']);
    $('#editCatModal').modal('hide'); 
  });

});


//ajax subcategory









// ajax view product
 var postCatId=0;
 var postCategoryElement=null;

$('#viewproductdetailed').find('.modalproduct').on('click',function(event){
 // event.preventDefault();
 $('#modalproduct').modal('show'); 
});


/* ajax cart increment
$('.cart_quantity_up, .cart_quantity_down').on('click', function(e) {
    e.preventDefault();
    var $this = $(this),
        url = $this.data('route'),
        increase = $this.data('increase');

    updateQty(url, increase);
});

function updateQty(url, increase){
    var $qty = $('.cart_quantity_input')+1,
        itemId = $('.item_id').val();
  
   $.ajax({
      method:'POST',
      url: url,
         
      data:{ amount: $qty.val() , itemId: itemId, _token:token}
  })
  .done(function (msg){
    $(postCategoryElement).text(msg['amount updated']);
  
  });


}
*/

// sidebar toggle
$(document).ready(function(e){
  $('.has-sub').click(function(){
    $(this).toggleClass('tap');
  });
});
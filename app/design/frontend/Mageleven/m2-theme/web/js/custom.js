require(['jquery'], function ($) {

  editionProdcts("Community");
  
  $(".edition_type").click(function(){
    $(".edition_type").removeClass("active_eece");
    var edition_type = $(this).attr("data-type");
    $(this).addClass("active_eece");
    $(".search_eece").attr("data-type",edition_type);
    $(".search_eece").val('');
    editionProdcts(edition_type);
  });

  function editionProdcts(edition){
    $(".ajaxloader").show();
    $.ajax({
        context: '.list-products',
        url: AjaxUrl+'itheavens/index/view',
        type: "POST",
        data: {edition:edition},
        showLoader: true 
    }).done(function (data) {
        $('.list-products').html(data.output);
        $(".ajaxloader").hide();
    });
  }

  
  $( "body" ).on( "click", ".btn_search_eece", function() {
    
    var edition = $(".search_eece").attr("data-type");
    var search = $(".search_eece").val();
    $(".ajaxloader").show();
    $.ajax({
      context: '.list-products',
      url: AjaxUrl+'itheavens/index/view',
      type: "POST",
      data: {search:search,edition:edition},
    }).done(function (data) {
      $('.list-products').html(data.output);
      $(".ajaxloader").hide();
    });
    
  });


  //bundleeditionProdcts();
  $( ".flexibility" ).on( "click", ".discount_product", function() {
    var product_id = $(this).attr("data-id");
    $(".ajaxloader").show();
    $.ajax({
        context: '.bundle-whbox',
        url: AjaxUrl+'itheavens/index/bundle',
        type: "POST",
        data: {product_id:product_id},
    }).done(function (data) {
        $('.bundle-whbox').html(data.output);
        $(".ajaxloader").hide();
        
    });
  });

  
 
  $( ".flexibility" ).on( "click", ".discount_producta", function() {
    var product_id = $(this).attr("data-id");
    $(".ajaxloader").show();
    $.ajax({
        context: '.bundle-whbox',
        url: AjaxUrl+'itheavens/index/removebundle',
        type: "POST",
        data: {product_id:product_id},
    }).done(function (data) {
        $('.bundle-whbox').html(data.output);
        $(".ajaxloader").hide();
        
    });
  });

  $( ".flexibility" ).on( "click", ".bundle_addToCart", function() {
    $(".ajaxloader").show();
    $.ajax({
        context: '.bundle-whbox',
        url: AjaxUrl+'itheavens/index/bundleaddtocart',
        type: "POST",
    }).done(function (data) {
        //$('.bundle-whbox').html(data.output);
        window.location.href = AjaxUrl+'checkout/cart';
    });
  });


});
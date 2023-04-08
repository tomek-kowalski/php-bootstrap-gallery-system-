$(document).ready(function() {
    $('#summernote').summernote({
      height:200
    });
    });

    (function () {
      if (typeof EventTarget !== 'undefined') {
        let supportsPassive = false;
        try {
          // Test via a getter in the options object to see if the passive property is accessed
          const opts = Object.defineProperty({}, 'passive', {
            get: () => {
              supportsPassive = true;
            },
          });
          window.addEventListener('testPassive', null, opts);
          window.removeEventListener('testPassive', null, opts);
        } catch (e) {}
        const func = EventTarget.prototype.addEventListener;
        EventTarget.prototype.addEventListener = function (type, fn) {
          this.func = func;
          this.func(type, fn, supportsPassive ? { passive: false } : false);
        };
      }
    })();

$(document).ready(function() {

  var user_href;
  var user_href_splitted;
  var user_id;

  var image_src;
  var image_src_splitted;
  var image_name;
  var photo_id;

  $(".modal_thumbnails").click(function() {
  $("#set_user_image").prop("disabled", false);  
  

  $(this).addClass('selected');
  user_href = $('#user_id').prop('href');
  user_href_splitted = user_href.split('=');
  user_id = user_href_splitted[user_href_splitted.length-1];

  image_src = $(this).prop('src');
  image_src_splitted = image_src.split('/');
  image_name = image_src_splitted[image_src_splitted.length-1];

  photo_id = $(this).attr("data");

  $.ajax({
    url: "includes/ajax_code.php",
    data: {photo_id:photo_id},
    type: "POST",
    success: function(data) {
      if(!data.error) {
        $("#modal_sidebar").html(data);
      }
    }
  })

  });

  $("#set_user_image").click(function() {


    $.ajax({
                url: "includes/ajax_code.php",
                data:{image_name: image_name,user_id: user_id},
                type: "POST",
                success:function(data) {
                    if(!data.error) {
                      jQuery(".user_image_box a img").prop('src', data);
                      
                      //location.reload(true);
                    }
                } // success
          }); //end ajax
  });



});

$(".info-box-header").click(function() {
  $(".inside").slideToggle("fast");
  $("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");
});

$(".delete_link").click(function(e) {

var r = confirm("Are you sure you want to delete this item?");
if(r == true) {

} else {
e.preventDefault;
return false;
}

});
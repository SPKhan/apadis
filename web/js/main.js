$('#image-search-form').hide();
$('#show-image-form').click(function(){
    $('#image-search-form').show();
    $('#text-search-form').hide();
    $('#preview').show();   
});
$('#show-text-form').click(function(){
    $('#image-search-form').hide();
    $('#preview').hide();
    $('#text-search-form').show();
    
});
$('#submit-pest').click(function(){
    $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',true);
    $('#text-search-form').submit();
});
$('#submit-disease').click(function(){
    $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',true);
    $('#text-search-form').submit();
});
$('#submit-pest-image').click(function(){
    $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',true);
    $('#image-search-form').submit();
});
$('#submit-disease-image').click(function(){
    $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',true);
    $('#image-search-form').submit();
});
$('#submit-pest').blur(function(){
    $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',false);
});
$('#submit-disease').blur(function(){
    $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',false);
});
$('#submit-pest-image').blur(function(){
    $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',false);
});
$('#submit-disease-image').blur(function(){
    $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',false);
});
function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#preview')
            .attr('src', e.target.result)
            .width(300)
            .height(200);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
//---------------------------------------------------

$('.th-btn').on('click', function(){

  $('.list-btn').removeClass('btn-primary');
  $('.th-btn').removeClass('btn-default');

  $('.list-btn').addClass('btn-default');
  $('.th-btn').addClass('btn-primary');

  $('.thumbnail-format').css('display','block');
  $('.list-format').css('display','none');

});

$('.list-btn').on('click', function(){

  $('.th-btn').removeClass('btn-primary');
  $('.list-btn').removeClass('btn-default');

  $('.th-btn').addClass('btn-default');
  $('.list-btn').addClass('btn-primary');

  $('.list-format').css('display','block');
  $('.thumbnail-format').css('display','none');

});

$('.entry').on('click', function(){

  var className = $(this).attr('class');
  var classNames = className.split(" ");
  for (i = 0; i < classNames.length; i++) {
    if(/entry-\d/.test(classNames[i])){
      var num = /\d/.exec(classNames[i]);

      $('.caption-' + num).css('display','block');

    }
  }

});

$('.caption-close-btn').on('click',function(){

  $(this).parent().css('display','none');

});
$(function (){
	'use strict';

    //hide olaceholder on form focus
	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));

	});

    
//add asteri  on required field 
$("input, select").each(function() {

        if ($(this).attr('required')){

        $(this).before('<span class="asterik">*</span>');
        
   }
});




var pass=$('.password');
  $('.show-pass').hover(function(){
     pass.attr('type','text');
},function(){

    pass.attr('type','password');
});


//confirmation code 
$('.confirm').click(function(){

    return confirm('ARE YOU SURE TO DELETE THIS MEMBER?');
});

$("select").selectBoxIt({
	autoWidth: false
});	


});

//review this function of java script
function check(){

	var checkBox=document.getElementById('CHeck');
	var text = document.getElementById("text"); 

	  if (checkBox.checked == true){
   text.style.display = "none";
  } else {
   text.style.display = "block";
  }

};
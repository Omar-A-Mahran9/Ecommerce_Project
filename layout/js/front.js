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




//confirmation code 
$('.confirm').click(function(){

    return confirm('ARE YOU SURE TO DELETE THIS MEMBER?');
});

$("select").selectBoxIt({
	autoWidth: false
});	



$('.loginPage h1 span' ).click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	$('.loginPage form').hide();
	$("."+$(this).data('class')).show();
});

});


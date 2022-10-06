$(function(){
    'use strict';
    
    //switch between login & signup
    $('.login-page h1 span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.'+$(this).data('class')).fadeIn(100);
    });

    // Calls the selectBoxIt method on your HTML select box and uses the default theme
    $("select").selectBoxIt({
        autoWidth:false
    });

    //hide placeholder in form focus
    $('[placeholder]').focus(function(){
       $(this).attr('data-text',$(this).attr('placeholder'));
       $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    //Add asterisk on required field
    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>');
         }
    });

    

    //confirm
    $('.confirm').click(function(){
        return confirm('Are You Sure?');
    });

    $('.live-name').keyup(function(){
        console.log($(this).val());
         $('.live-preview .caption h3').text($(this).val());
    });

    $('.live-desc').keyup(function(){
        console.log($(this).val());
         $('.live-preview .caption p').text($(this).val());
    });

    $('.live').keyup(function(){
        
         $($(this).data('class')).text($(this).val());
    });

    

});
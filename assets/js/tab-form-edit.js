window.$ = require('jquery');

$(document).ready(function(){
    $(".delete-tag").click(function() {
        $(this).parent().parent().remove();
    });
    
    $(".delete-category").click(function() {
        $(this).parent().parent().remove();
    });

    $(".delete-image").click(function() {
        $(".image-edit").attr({
            'src': '/img/placeholder.jpg',
            'alt': 'placeholder'
        });
        $('html, body').animate({ 
            scrollTop: ($(".image-edit").offset().top)
        }, 'fast');
    });
});
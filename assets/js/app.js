
require('./../scss/app.scss');

window.$ = require('jquery');

window.Popper = require('popper.js');

require('bootstrap');

$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
});


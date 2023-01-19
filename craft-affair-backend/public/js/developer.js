$(document).on('keypress','.chkNumber',function(e){
    var keyCode = e.keyCode || e.which;

    //Regex for Valid Characters i.e. Alphabets and Numbers.
    var regex = /^[0-9]+$/;

    //Validate TextBox value against the Regex.
    var isValid = regex.test(String.fromCharCode(keyCode));
    if(!isValid){
        //alert('Only Numbers are allowed.');
    }

    return isValid;
});

$(document).on('keypress', '.chkNumberDecimal', function(e){
    var keyCode = e.keyCode || e.which;

    //Regex for Valid Characters i.e. Alphabets and Numbers.
    var regex = /^[0-9.]$/;

    //Validate TextBox value against the Regex.
    var isValid = regex.test(String.fromCharCode(keyCode));
    if(!isValid){
        //alert('Only Numbers are allowed.');
    }

    return isValid;
});

$(document).on('keypress', '.chkAlpha', function(e){
    var keyCode = e.keyCode || e.which;

    //Regex for Valid Characters i.e. Alphabets and Numbers.
    var regex = /^[A-Za-z]+$/;

    //Validate TextBox value against the Regex.
    var isValid = regex.test(String.fromCharCode(keyCode));
    if(!isValid){
        //alert('Only Alphabets are allowed.');
    }

    return isValid;
});

$(document).on('keypress', '#property_name',function(e){
    var len = $(this).length;
    if(len<=65){
        return true;
    }
    return false;
});

$(document).on('keypress', '.discount_per',function(e){
    var curr_key = e.key;
    var per_val = $(this).val();
    var curr_val = per_val+e.key;
    if(curr_val>0 && curr_val<=100){
        return true;
    }else{
        return false;
    }
});

$(document).on('input', '.minMaxLength',function(){
    var min_max_value = $(this).val();
    if(min_max_value>=0 && min_max_value<=99){
        return true;
    }
    if(min_max_value=="" || min_max_value<0){
        $(this).val(0);
    }else if(min_max_value>99){
        $(this).val(99);
    }
    return false;
});

$(".mob_no").on("keypress",function(){
    var mob_no = $(this).val();
    if(mob_no.length>=12){
        return false;
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    $('.nav-menu li:has(ul)').closest('.nav-item').addClass('menu-has-children');
    $('.menu-has-children').children('.nav-link').addClass('toogleLink');
    $('.menu-has-children').children('.nav-link').append('<span class="float-right"><i class="far fa-chevron-right"></i></span>');
    $('.toogleLink').click(function(){
        $(this).toggleClass('active');
    });
});
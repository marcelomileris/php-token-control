var messageBox = function(amsg, atype = 'error') {
    var color, size;
    if (atype == 'error')
        color = 'red';
    else if (atype == 'alert')
        color = 'blue';
    // Sets the size according to the number of characters
    size = 'small';
    if (amsg.length > 30)
        size = 'col-md-6 col-md-offset-3';
    $.confirm({
        title: '',
        content: amsg,
        type: color,
        typeAnimated: true,
        columnClass: size,
        animation: 'scaleX',
        closeAnimation: 'scaleX',
        animateFromElement : false,
        backgroundDismiss: true,
        buttons : {
            CLOSE:  {
                    text: 'ok',
                    btnClass: 'btn-'+color,
                    action: function(){
                }
            }
        }
    });
}
/**************************************************************************/
var validateFields = function() {
    
    $(".form-signin").validate({
        rules: {
            'user' : "required",
            'pass' : "required"
        },
        messages: {
            'user' : "user required!",
            'pass' : "pass required!"
        },
        submitHandler: function (){
            user = $("#user").val();
            pass = $("#pass").val();
            $.ajax({
                type        : 'POST',
                url         : 'php/login.php',
                data : {
                    user : user,
                    pass : pass
                },  
                beforeSend : function() {
                    // action    
                },
                success : function(res) {
                    console.log(res);
                    res = $.parseJSON(res);
                    id = res.id;
                    if (id == -1) {
                        messageBox(res.message);
                    } else {
                        window.location.replace("panel/");    
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("error: " + xhr.status);
                    console.log("error: " + thrownError);
                }
            });  
        }
    });

    
    

    /*
    
    */  
}
/**************************************************************************/
/**************************************************************************/


jQuery(function(){
    validateFields();
    
});

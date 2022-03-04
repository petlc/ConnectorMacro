
$(document).ready(function(){
    var myName;
    var myNameSelect;
    var x = 1; //Initial field counter is 1
    var maxField = 10; //Input fields increment limitation Account-Request
    var addUalsButton = $('.add_uals_form_button'); //Add button selector
    var ualswrapper = $('.uals_form'); //Input field wrapper
    //var ualsfieldHTML = ;
    //New input field html
    $('.dtld_dtls').hide();
    //Once add button is clicked
    $("input[type=checkbox]").attr("disabled", true);
    $(".skills").prop("disabled", true);

    $(ualswrapper).on('change', 'select', function(event){
        myName = '.'+this.name;
        var thisParent = $(this).parent().parent();
        var grandp  = $(thisParent).attr("class");

        //alert(grandp);
        //alert($( this ).val());
        rqst = $( this ).val();

        if ( rqst != '' ) {
            $( myName + " input[type=checkbox]").removeAttr("disabled");
            $( myName + " .skills").prop("disabled", false);
        }else{
            $( myName + " input[type=checkbox]").attr("disabled", true);
            $( myName + " .skills").prop("disabled", true);
        }

        switch (rqst) {
            case 'Add':
                $(myName+' input[type=checkbox]').prop('checked', false);
                break;

            case 'Edit':
                $(myName+' input[type=checkbox]').prop('checked', false);
                $(myName+' .dtld_dtls').hide();
                $(myName+' .cmplt_dtls').show();
                break;

            case 'Delete':
                $(myName+' input[type=checkbox]').prop('checked', false);
                $(myName+' .dtld_dtls').hide();
                $(myName+' .cmplt_dtls').show();
                break;

            default:

        }


    });

    $(ualswrapper).on('click', '.win', function(event){
        var thisParent = $(this).parent().parent().parent().parent();
        var grandp  = $(thisParent).attr("class");

        //alert(grandp);

        var grandC = grandp.split(' ');
        alert(grandC[1]);

        var rqst2 = $('select[name='+grandC[1]+']').val();
        //alert(rqst2);
        if ($(this).prop('checked') && rqst2 === "Add") {
            alert("Windows");
            $('.'+grandC[1]+' .dtld_dtls').show();
            $('.'+grandC[1]+' .cmplt_dtls').hide();
        }else if ($(this).prop('checked') && rqst2 === "Add") {
            alert("Windows2");
            $('.'+grandC[1]+' .dtld_dtls').show();
            $('.'+grandC[1]+' .cmplt_dtls').hide();
        }else{
            alert('hindi');
            $('.'+grandC[1]+' .dtld_dtls').hide();
            $('.'+grandC[1]+' .cmplt_dtls').show();
        }
    });


});


    $(function () {
      $('[toggle="popover"]').popover({
          trigger : 'hover'
      })
    });
    $(document).ready(function(){
        $('textarea, input[type=text]').keydown(function (e){
            if(e.keyCode == 186){
                //alert('you pressed enter ^_^');
                event.preventDefault();
            }
        });
    });

    $(document).ready(function(){
        $('div[name=purchased_conforms]').hide();
        $('input[type=radio][name=require_purchase]').change(function() {
            if (this.value == 'Yes') {
                $('div[name=purchased_conforms]').show();
                $('input[name=conforms]').prop('required',true);
            }else{
                $('div[name=purchased_conforms]').hide();
                $('input[name=conforms]').prop('required',false);
            }
        });
        $(".dis-checked").prop("checked", true);
        $(".dis-checked").attr("disabled", true);
        $(".dis").attr("disabled", true);


    });
    $(document).ready(function(){
        $('div[name=conforms_reason]').hide();
        $('input[type=radio][name=conforms]').change(function() {
            if (this.value == 'No') {
                $('div[name=conforms_reason]').show();
                $('div[name=conforms_reason]').prop('required',true);
            }else{
                $('div[name=conforms_reason]').hide();
            }
        });

    });
    $(document).ready(function(){
        $('div[name=adjust_date]').hide();
        $('label[name=adjust_date]').hide();
        $('input[type=radio][name=date_change]').change(function() {
            if (this.value == 'Yes') {
                $('div[name=adjust_date]').show();
                $('label[name=adjust_date]').show();
                $('input[name=adjusted_date]').prop('required',true);
            }else{
                $('div[name=adjust_date]').hide();
                $('label[name=adjust_date]').hide();
                $('input[name=adjusted_date]').prop('required',false);
            }
        });

    });

    $(document).ready(function(){
        $('div[name=officer]').hide();
        $('select[name=status]').change(function() {
            if (this.value == 'Endorsed to Checker') {
                $('div[name=officer]').show();
                $('option[data-officer=checker]').prop('required',true);
                $('option[data-officer=checker]').toggle(true);
                $('option[data-officer=approver]').toggle(false);
                $("option[data-officer=approver]").prop("selected", false);
                $('.officer-role').text('Checker:');
            }else if (this.value == 'Endorsed to Approver') {
                $('div[name=officer]').show();
                $('option[data-officer=approver]').prop('required',true);
                $('option[data-officer=approver]').toggle(true);
                $('option[data-officer=checker]').toggle(false);
                $("option[data-officer=checker]").prop("selected", false);
                $('.officer-role').text('Approver:');
            }else{
                $('div[name=officer]').hide();
                $('select[name=officer]').prop('required',false);
            }
        });

    });

    $(document).ready(function(){
        $('textarea[name=other_location]').hide();
        $('input[type=radio][name=option_directory]').change(function() {
            if (this.value == 'Other') {
                $('textarea[name=other_location]').show();
            }else{
                $('textarea[name=other_location]').hide();
            }
        });
    });
    /*
    $(document).ready(function(){
        $("input[name='file[]']").change(function() {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            var file = console.log(names);
            var n = names.length;
            alert(names);
            $(".filename").text(names);
        });
    });
    */
    $(function(){
        $('.update_datetime').appendDtpicker({
                "autodateOnStart": false,
                "dateFormat": "MM/DD/YYYY",
                "futureOnly": true,
                "dateOnly": true,
                //"minTime":"06:30",
                //"maxTime":"21:30",
                "minDate":+5,
                "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
            });
    });
    
    $(function(){
        $('.change_csr_datetime').appendDtpicker({
                "autodateOnStart": false,
                "dateFormat": "MM/DD/YYYY hh:mm",
                "futureOnly": true,
                //"dateOnly": true,
                "minTime":"06:30",
                "maxTime":"21:30",
                "minDate":+5,
                "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
            });
    });
    


    $(function(){
        $('.csr_datetime').appendDtpicker({
                "autodateOnStart": false,
                "dateFormat": "MM/DD/YYYY hh:mm",
                "futureOnly": true,
                //"dateOnly": true,
                "minTime":"06:30",
                "maxTime":"21:30",
                "minDate":+5,
                "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
            });
    });



    $(function(){
        $('.cpr_datetime').appendDtpicker({
                "autodateOnStart": false,
            "dateFormat": "MM/DD/YYYY hh:mm",
            //"futureOnly": true,
            "minTime":"06:30",
            "maxTime":"21:30",
            "minDate":+5,
            "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
        });
    });

    $(function(){
        $('#edit_cpr_datetime').appendDtpicker({
                "autodateOnStart": false,
            "dateFormat": "MM/DD/YYYY hh:mm",
            //"futureOnly": true,
            "minTime":"06:30",
            "maxTime":"21:30",
            "minDate":+5,
            "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
        });
    });



    $(function(){
        $('.drr_datetime').appendDtpicker({
            "dateFormat": "MM/DD/YYYY hh:mm",
            //"futureOnly": true,
            //"minTime":"06:30",
            //"maxTime":"21:30",
            //"minDate":+5,
            //"allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
        });
    });

    $(function(){
        $('#edit_drr_datetime').appendDtpicker({
            "dateFormat": "MM/DD/YYYY hh:mm",
            //"futureOnly": true,
            //"minTime":"06:30",
            //"maxTime":"21:30",
            "minDate":+5,
            "allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
        });
    });

    $(document).ready(function(){
        $('[search-toggle=search]').click(function(){
            $('.search-bar').toggle();
        });
        $('.modal-dialog').draggable();
    });


    $(document).ready(function(){
        $('textarea, input[type=text]').keydown(function (e){
            if(e.keyCode == 186){
                //alert('you pressed enter ^_^');
                event.preventDefault();
            }
        });
    });

    $(document).ready(function(){

        $("textarea, input[type=text]").on("change paste keyup", function() {
           //alert($(this).val());
           var myStr =  $(this).val();

           var  newStr =  myStr.replace(/;/g,',');

           $(this).val(newStr);
        });

    });


    function spinner() {
        document.getElementById('waitani').style.visibility = 'visible';
            $('#endorsment-form').modal('hide');
            $('#mis-endorse-form').modal('hide');
            $('#acknowledge-form').modal('hide');
            $('#done-form').modal('hide');
            $('#close-form').modal('hide');
            $('#complete-form').modal('hide');
            $('#update-date-form').modal('hide');
            $('#edit-form').modal('hide');
            $('#csrf-form').modal('hide');
            $('#cprf-form').modal('hide');
            $('#drrf-form').modal('hide');

        }

    function spinneroff() {
        document.getElementById('waitani').style.visibility = 'visible';
        }

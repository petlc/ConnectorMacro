
$(document).ready(function(){
    $('[search-toggle=search]').click(function(){
        $('.search-bar').toggle();
    });
});

$(document).ready(function(){
    var attached_file, suggested_date, branch_site, request, csr_datetime, workingDays;
    var datestart   = $('.csr_created_date').val();

    $('.account_rqst').hide();
    $('.access_rqst').hide();

    $('input[name=cpr_ip_address]').keypress(function(event) {
      if ((event.which != 46 ) && (event.which < 48 || event.which > 57)) {
            //$(".errmsg").html("Digits Only").show();
            alert("Ip address is Number and Dot only!");
            return false;
      }
    });
    $('input[name=csr_ip_address]').keypress(function(event) {
      if ((event.which != 46 ) && (event.which < 48 || event.which > 57)) {
            //$(".errmsg").html("Digits Only").show();
            alert("Ip address is Number and Dot only!");
            return false;
      }
    });

    $('input[name=requestor_local]').keypress(function(event) {
        if ((event.which != 46 ) && (event.which < 48 || event.which > 57)) {
              //$(".errmsg").html("Digits Only").show();
              alert("local number are 3 digits only!");
              return false;
        }
      });

    $('select[name=branch_site]').change(function(){
        branch_site = $('select[name=branch_site]').val();
        //request     = $('select[name=request_category]').val();

        if (request == null  &&  csr_datetime == null) {

            //$('select[name=request_category]').focus();
            $('.csr_datetime').focus();
            //alert(request+" "+csr_datetime+" focus");

        }else{
            suggested_date = purchase(branch_site, request, datestart);
            $('.csr_datetime').val(formatDate(suggested_date)+' 21:00');
            //alert(branch_site+" "+request+" "+csr_datetime+" triggered");
        }


    });

    $('.csr_datetime').change(function() {
        csr_datetime = $(this).val();
        var s_csr_datetime = new Date(csr_datetime);
        var newcsr_datetime = ('0' +(s_csr_datetime.getMonth() + 1)).slice(-2) + '/' + s_csr_datetime.getDate() + '/' + s_csr_datetime.getFullYear();

        var s_datestart = new Date(datestart);
        var newdatestart = ('0' +(s_datestart.getMonth() + 1)).slice(-2) + '/' + s_datestart.getDate() + '/' + s_datestart.getFullYear();
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var output =  (month<10 ? '0' : '') + month + '/' +(day<10 ? '0' : '') + day + '/' +d.getFullYear();

        if (request === null  ||  branch_site === null) {

            //alert("Null and Null");
            suggested_date = returnfinaldate(datestart, 1);
            $('.csr_datetime').val(formatDate(suggested_date) +' 21:00');
        }

        if (request != null  &&  branch_site != null) {


            if (newdatestart === newcsr_datetime) {
                alert("Same date not allowed, thank you");

                if (request === 'Hardware Purchase' || request === 'Software Purchase' || request === 'Renewal License') {

                    suggested_date = purchase(branch_site, request, newdatestart);

                }else{
                    suggested_date = returnfinaldate(newdatestart, 1);
                }
                //alert("Not Null and Not Null same date");
                $('.csr_datetime').val(formatDate(suggested_date) +' 21:00');


            }else if(newdatestart < newcsr_datetime){
                var d0 = new Date(newcsr_datetime);
                var newcsr_datetime = d0.getFullYear()+ '-' +('0' +(d0.getMonth() + 1)).slice(-2)+ '-' +  ('0' +d0.getDate()).slice(-2);
                var d1 = new Date(newdatestart);
                var newdatestart = d1.getFullYear()+ '-' +('0' +(d1.getMonth() + 1)).slice(-2)+ '-' +  ('0' +d1.getDate()).slice(-2);

                workingDays = workingDaysBetweenDates(newdatestart,newcsr_datetime);

                //alert(workingDays+" "+newdatestart+" "+newcsr_datetime);

                if (request === 'Hardware Purchase' || request === 'Software Purchase' || request === 'Renewal License') {

                    suggested_date = purchase(branch_site, request, newdatestart);

                    var sd = new Date(suggested_date);
                    var newsuggested_date = sd.getFullYear()+ '-' +('0' +(sd.getMonth() + 1)).slice(-2)+ '-' +  ('0' +sd.getDate()).slice(-2);
                    if (newsuggested_date < newcsr_datetime) {

                        suggested_date = newcsr_datetime;
                        alert("Your request date for "+branch_site+" "+request+" is Appreciated");
                    }else{
                        alert("Suggested Date for "+branch_site+" "+request+" "+formatDate(suggested_date));
                    }

                    //alert(newsuggested_date +" "+newcsr_datetime);
                    //alert("Not Null and Not Null purchase");
                }else{
                    //suggested_date = returnfinaldate(newdatestart, workingDays);
                    suggested_date = csr_datetime;
                    //alert("Not Null and Not Null not purchase");
                }

                $('.csr_datetime').val(formatDate(suggested_date) +' 21:00');
            }
        }
    });




    $('select[name=request_category]').change(function(){
        //branch_site = $('select[name=branch_site]').val();
        request     = $('select[name=request_category]').val();

        //alert(branch_site+" "+request);
        if (branch_site !="" && branch_site != null) {

            if (request === 'Hardware Purchase' || request === 'Software Purchase' || request === 'Renewal License') {
                $('.account_rqst').hide();
                $('.access_rqst').hide();

                suggested_date = purchase(branch_site, request, datestart);

            }else if (request == 'Account Request') {
                $('.account_rqst').show();
                $('.access_rqst').hide();
                suggested_date = returnfinaldate(datestart,7);
            }else if (request == 'Access Request') {
                $('.access_rqst').show();
                $('.account_rqst').hide();
                suggested_date = returnfinaldate(datestart, 7);
            }else{
                $('.account_rqst').hide();
                $('.access_rqst').hide();
                //suggested_date = returnfinaldate(datestart, 1);
                $('.csr_datetime').trigger("change");
            }
            //$('.csr_datetime').val("");
            $('.csr_datetime').val(formatDate(suggested_date) +' 21:00');


        }else{
            $('select[name=branch_site]').focus();
            suggested_date = returnfinaldate(datestart, 1);
            $('.csr_datetime').val(formatDate(suggested_date) +' 21:00');

        }
    });



    $("input[name='file[]']").change(function() {
        attached_file = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            attached_file.push($(this).get(0).files[i].name);
        }
        var file = console.log(attached_file);
        var n = attached_file.length;
        //alert(names);
        $(".filename").text(attached_file);
    });

    $('#submit_csr').click(function() {
        var ipAddress = $('input[name=csr_ip_address]').val();
        var local = $('input[name=requestor_local]').val();
        var d0 = new Date(datestart);
        var newcsr_datetime = d0.getFullYear()+ '-' +('0' +(d0.getMonth() + 1)).slice(-2)+ '-' +  ('0' +d0.getDate()).slice(-2);
        var d1 = new Date(csr_datetime);
        var newdatestart = d1.getFullYear()+ '-' +('0' +(d1.getMonth() + 1)).slice(-2)+ '-' +  ('0' +d1.getDate()).slice(-2);

        
        if (ipAddress === '' || ipAddress.lenth < 1){
            alert("Please input IP address, Thank you");
            $('input[name=csr_ip_address]').focus();
            return false;
        }

        if (local === '' || local.lenth < 1){
            alert("Please input local for easy and fast communication, Thank you");
            $('input[name=requestor_local]').focus();
            return false;
        }

        if( csr_datetime === null){
            alert("please input date, Thank you");
            $('#csr_datetime').focus();
            return false;
        }

        if (request == 'Hardware Purchase') {

            workingDays = workingDaysBetweenDates(d0, d1);

            if ( branch_site === 'HO' && workingDays < 65) {
                alert('The date time inputed is not equal or greater than 65 Days for '+branch_site +' site, You input '+workingDays+' day/s only. Suggest date will apply');
                $('select[name=request_category]').trigger('change');
                $('#csr_datetime').focus();
                return false;
            }else if (branch_site === 'BO' && workingDays < 70) {
                alert('The date time inputed is not equal or greater than 70 Days for '+branch_site +' site, You input '+workingDays+' day/s only. Suggest date will apply');
                $('select[name=request_category]').trigger('change');
                $('#csr_datetime').focus();
                return false;
            }


        }else if (request === 'Software Purchase' || request === 'Renewal License') {

            workingDays = workingDaysBetweenDates(d0, d1);

            if ( workingDays < 30) {
                alert('The date time inputed is not equal or greater than 30 Days for '+request +' request, You input '+workingDays+' day/s only.');
                $('#csr_datetime').focus();
                return false;
            }
        }else if (request === 'Account Request') {
            /*
            if (attached_file === "Account Request Form.xls" || attached_file === "Account Request Form.xlsx") {

            }else{
                //alert(attached_file);
                alert('Please attached the '+attached_file+' 1');
                $('input[type=file]').focus();
                return false;
            }
            */
        }else if (request === 'Access Request') {
            /*
            if (attached_file === 'Access Request Form.xls' || attached_file === 'Access Request Form.xlsx') {

            }else{
                //alert(attached_file);
                alert('Please attached the '+attached_file+' 2');
                $('input[type=file]').focus();
                return false;
            }
            */
        }else if(request === ''){
            alert('Please choose your request.')
            $('select[name=request_category]').focus();
            return false;
        }

    });

    $('#submit_cpr').click(function() {

        if($('#cpr_datetime').val().length < 1){
            alert("please input date, Thank you");
            $('#cpr_datetime').focus();
            return false;
        } else if ($('input[name=cpr_ip_address]').val().length < 1){
            alert("Please input IP address, Thank you");
            $('input[name=cpr_ip_address]').focus();
            return false;
        }
    });

    $('#submit_drr').click(function() {

        if($('#drr_datetime').val().length < 1){
            alert("please input date, Thank you");
            $('#drr_datetime').focus();
            return false;
        }
    });

    $(".dis-checked").prop("checked", true);
    $(".dis-checked").attr("disabled", true);
    $(".dis").attr("disabled", true);

    var x;

    $('.path1').focus(function(){
        /*to make this flexible, I'm storing the current width in an attribute*/
        $(this).attr('data-default', $(this).width());
        $(this).animate({ width: 150 }, 'slow');
    }).blur(function()
    {
        /* lookup the original width */
        var w = $(this).attr('data-default');
        $(this).animate({ width: w }, 'slow');
    });

    $('textarea, input[type=text]').keydown(function (e){
        if(e.keyCode == 186){
            //alert('you pressed enter ^_^');
            event.preventDefault();
        }
    });

    $('#acknowledge').click(function() {
        var request = $('input[name=request]').val();
        
        if (request === 'Hardware Purchase' || request === 'Software Purchase' || request === 'Renewal License') {
            if ($('input[name=prif_no]').val() == "") {
                alert("PRIF# is needed please create one for this request, Thank you!");
                return false
            } else {
                
            }
        }else{
            $('input[name=prif_no]').prop('required',false);
        }
        
    });
    $('input[name=require_purchase]').change(function() {
        if (this.value == 'Yes') {
            $('div[name=purchased_conforms]').show();
            $('input[name=conforms]').prop('required',true);
        }else{
            $('div[name=purchased_conforms]').hide();
            $('input[name=conforms]').prop('required',false);
        }
    });

});

 $(function () {
   $('[toggle="popover"]').popover({
       trigger : 'hover'
   })
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


function checkDate_needed(needed, actual, site, request) {

    if (needed < actual) {
        //alert("late na");
    } else {
        //alert("Pede pa");
    }
    
}

function purchase(site, category, datestart){

    if (category == 'Hardware Purchase') {
        $('.account_rqst').hide();
        $('.access_rqst').hide();

        if ( site == 'HO' ) {
            suggested_date = returnfinaldate(datestart, 65);
        }else if (site == 'BO') {
            suggested_date = returnfinaldate(datestart, 70);
        }

    }else if (category == 'Software Purchase' || category === 'Renewal License') {
        suggested_date = returnfinaldate(datestart, 30);

    }else{
        suggested_date = returnfinaldate(datestart, 1);
    }

    return suggested_date;
}

function workingDaysBetweenDates(d0, d1) {
	var holidays = ['2019-02-05','2019-02-25','2019-04-09','2019-04-18','2019-04-19','2019-05-01','2019-06-12'];
    var startDate = parseDate(d0);
    var endDate = parseDate(d1);
    // Validate input

    if (endDate < startDate) {
        return 0;
    }
    // Calculate days between dates
    var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
    startDate.setHours(0,0,0,1);  // Start just after midnight
    endDate.setHours(23,59,59,999);  // End just before midnight
    var diff = endDate - startDate;  // Milliseconds between datetime objects
    var days = Math.ceil(diff / millisecondsPerDay);

    // Subtract two weekend days for every week in between
    var weeks = Math.floor(days / 7);
    days -= weeks * 2;

    // Handle special cases
    var startDay = startDate.getDay();
    var endDay = endDate.getDay();

    // Remove weekend not previously removed.
    if (startDay - endDay > 1) {
        days -= 2;
    }
    // Remove start day if span starts on Sunday but ends before Saturday
    if (startDay == 0 && endDay != 6) {
        days--;
    }
    // Remove end day if span ends on Saturday but starts after Sunday
    if (endDay == 6 && startDay != 0) {
        days--;
    }
    /* Here is the code */
    for (var i in holidays) {
      if ((holidays[i] >= d0) && (holidays[i] <= d1)) {
      	days--;
      }
    }
    return days-1;
}

function parseDate(input) {
	// Transform date from text to date
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}



function returnfinaldate(cdate, days) {
        var holidays = ['2019-02-05','2019-02-25','2019-04-09','2019-04-18','2019-04-19','2019-05-01','2019-06-12'];
        //holiday[0] = new Date(2017, 9, 5);// holiday 1
        //holiday[1] = new Date(2017, 9, 6);//holiday 2
        var startDate = new Date(cdate);
        var endDate = new Date(cdate);
        //startDate = cdate;// '8/1/2017';
        noOfDaysToAdd = days, count = 0;
        endDate = startDate;
  //use below code to include start date in count else comment below code
      //  if (endDate.getDay() != 0 && endDate.getDay() != 6 && !isHoliday(endDate, holiday)) {
         //   count++;
       // }
        while (count < noOfDaysToAdd) {
            endDate.setDate(endDate.getDate() + 1)
            // Date.getDay() gives weekday starting from 0(Sunday) to
            // 6(Saturday)
            if (endDate.getDay() != 0 && endDate.getDay() != 6 && !isHoliday(endDate, holidays)) {
                count++;
            }
        }
        return endDate;
    }


function isHoliday(dt, arr){
    var bln = false;
    for ( var i = 0; i < arr.length; i++) {
        if (compare(dt, arr[i])) { //If days are not holidays
            bln = true;
            break;
        }
    }
    return bln;
}

function compare(dt1, dt2){
    var dt1 = new Date(dt1);
    var dt2 = new Date(dt2);
    var equal = false;
    if(dt1.getDate() === dt2.getDate() && dt1.getMonth() === dt2.getMonth() && dt1.getFullYear() === dt2.getFullYear()) {
        equal = true;
    }
    return equal;
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [ month, day, year].join('/');
}

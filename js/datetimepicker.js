$(function(){
			 	// -- append by class just for lower strings count --
    $('.dtpicker2').appendDtpicker({"futureOnly": false, "autodateOnStart": false, "dateFormat": "MM/DD/YYYY", "dateOnly": true,});

    $('#startdt2').change(function() {
        var de = new Date($('#startdt2').handleDtpicker('getDate')); // constructor need to avoid linking object
        de.setDate(de.getDate() + 7);
        $('#enddt2').handleDtpicker('setMinDate', de); //set min end date is 7 day later then start date
    });
    $('#enddt2').change(function() {
        var ds = new Date($('#enddt2').handleDtpicker('getDate'));
        ds.setDate(ds.getDate() - 7);
        $('#startdt2').handleDtpicker('setMaxDate', ds); //set max end date is 7 day earlier then end date
    });
});
  
$(function(){
	$('#datetime').appendDtpicker({
		"dateFormat": "MM/DD/YYYY hh:mm",
		//"futureOnly": true,
		"minTime":"06:30",
		"maxTime":"21:30",
		"minDate":+5,
		"allowWdays": [1, 2, 3, 4, 5] // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thr, 5: Fri, 6: Sat
	});
});
$(document).ready(function(){
	$('div[name=a1]').hide();
	$('div[name=a2]').hide();
	$('input[type=radio]').change(function(){
		if (this.value =='1' ){
			$('div[name=a1]').show();
			$('div[name=a2]').hide();
		}else{
			$('div[name=a2]').show();
			$('div[name=a1]').hide();
		}
		
	});
	
});


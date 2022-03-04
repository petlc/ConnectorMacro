$(document).ready(function(){
$('div[name=a11]').hide();
$('div[name=a22]').hide();


	$('select[type=select]').change(function(){
		if (this.value =='Aseana1' ){
			$('div[name=a11]').show();
			$('div[name=a22]').hide();
			
}

		else if (this.value =='Aseana2' ){
			
			$('div[name=a11]').hide();
			$('div[name=a22]').show();
			

		
	}});
	
});


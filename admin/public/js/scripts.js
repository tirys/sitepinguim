$(document).ready(function() {
	


	

	/*-----------------------------------------------------------------------------------*/
	/*	Forçar apenas números
	/*-----------------------------------------------------------------------------------*/ 

	
		$(".sonumero").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
		if (event.keyCode < 95) {
		if (event.keyCode < 48 || event.keyCode > 57 ) {
		event.preventDefault();	
		}
		} else {
		if (event.keyCode < 96 || event.keyCode > 105 ) {
		event.preventDefault();	
		}
		}
		}
		});
		
		
	/*-----------------------------------------------------------------------------------*/
	/*	Data com Mouse Over
	/*-----------------------------------------------------------------------------------*/ 

	$(function() {
	$('#checkerino').change(function(){
		$(".seletorznho").toggleClass('hidden');
		if(!$(".seletorznho").hasClass('hidden'))
		{
			$('#offer').val('S');
		}
		else
		{
			$('#offer').val('');
		}
	});	
	if(!$(".seletorznho").hasClass('hidden'))
	{
		$('#offer').val('S');
	}
	else
	{
		$('#offer').val('');
	}
    $('#txt_data').datepicker({format: 'dd-mm-yyyy'});
    $('#txt_data_2').datepicker({format: 'dd-mm-yyyy'});
	$('#txt_data_inicializa').datepicker({format: 'dd-mm-yyyy'});
	$('#txt_data_finaliza').datepicker({format: 'dd-mm-yyyy'});
    });
		
});
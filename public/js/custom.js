window.onload = function() {
	var btnGenerarPago = document.getElementById("boton");
	
	btnGenerarPago.addEventListener("click", function(e, object){
		
		e.preventDefault();

		UIkit.modal.confirm('¿Seguro que desea enviar el formulario?', { labels: { ok: 'Si', cancel: 'No' }}).then(function (){
			console.log('Si.');
			var form = document.getElementsByTagName("form")[0];	
			form.submit();
  			
       	}, function () {
       		console.log('No.');
       	});
		
	});
}
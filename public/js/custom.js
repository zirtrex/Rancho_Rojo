window.onload = function() {
	var btnGenerarPago = document.getElementById("boton");
	
	btnGenerarPago.addEventListener("click", function(e, object){
		
		e.preventDefault();

		UIkit.modal.confirm('¿Seguro de agregar el pago?', { labels: { ok: 'Si', cancel: 'No' }}).then(function (){
			console.log('Si.');
			var form = document.getElementById("PagoForm");	
			form.submit();
  			
       	}, function () {
       		console.log('No.');
       	});
		
	});
}
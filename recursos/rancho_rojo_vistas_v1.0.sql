/********************************************
 *******************VISTAS*******************
 ********************************************/

USE rancho_rojo;

CREATE VIEW vw_pagos
AS
  SELECT p.codPago, p.numeroCuota, p.fechaPago, 
		p.formaPago, p.valor,  p.saldoAFecha, p.comprobante,
        t.codTerreno, t.manzana, t.codigoLote, t.lote, t.nombre, t.tamanio,
        t.precio, t.inicial, t.saldo, t.vendido, t.fechaVenta, t.cuotas, t.montoPagar,
		t.nombresComprador, t.apellidosComprador, t.telefonoComprador
  FROM pagos p
  LEFT JOIN terrenos t ON t.codTerreno = p.codTerreno;
  

/*CREATE VIEW vw_usuario
AS
  SELECT u.codUsuario, u.rol, u.usuario, u.clave,
        u.nombres, u.primerApellido, u.segundoApellido, u.numeroDNI,
        u.imagenDNI, u.enlaceFacebook, u.fechaNacimiento, u.correo, u.celular,
        u.imagenPerfil, u.imagenAdicional,
        u.fechaRegistro, u.tokenRegistro, u.correoConfirmado,
        ub.codUbicacion, ub.direccion, ub.distrito, ub.provincia, ub.departamento
  FROM usuario u
  LEFT JOIN ubicacion ub ON ub.codUbicacion = u.codUbicacion;*/
  



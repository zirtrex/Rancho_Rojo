# Sistema de Registro de Pagos - Rancho Rojo

## Descripción

Este pequeño sistema permitirá gestionar los Lotes con los que cuenta Rancho Rojo

## Instrucciones

El sistema usa Mysql >= 5.4, Zend Framework 3, JavaScript y el framework gráfico
[Uikit](http://getuikit.com/).
Está publicado en un servidor público por lo tanto no necesita instalación por parte
del usuario todo lo hace el webmaster.

Solo se han creado dos módulos:
- Application, desde donde se administra toda la funcionalidad de la aplicación
- Users, que contiene todas la funciones para trabajar con usuarios, login, logout, etc

## Cambios en el Tiempo

### 1.0.Dev
Primera versión de la aplicación.
- En su pantalla inicial muestra un mapa creada con el API de Google Maps, donde
se puede ver un mapa del Rancho (Ver imagen 01) un en cada chincheta la opción de
ver los lotes con el que cuenta cada manzana.
- A cada lote se pueden agregar pagos.
- Se cuenta con 3 reporte principales
-- Reporte gráfico de terrenos vendidos y que falta vender
-- Reporte de pagos
-- Reporte de pagos atrasados
- Permite tambien editar y agregar los terrenos 
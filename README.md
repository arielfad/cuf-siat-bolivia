# Generador de CUF SIAT

La generación del código único de factura en la modalidad de facturación en línea es un punto crucial en el proceso de habilitación ante el SIN. Es por eso que extraje este proceso en un pequeño pero util paquete para ahorrarte la tarea de implementar los algoritmos solicitados.

## Comenzando 🚀

Instalación del paquete:<br>

```
composer require arielfad/cuf-siat-bolivia
```

### Descripción de parámetros de la clase y valores de ejemplo para uso 🔧

Los parámetros que requiere la clase CufSiat son:

<ul>
<li>Nit del emisor.</li>
<li>Fecha y hora en formato YmdHisu.</li>
<li>Código de la sucursal.</li>
<li>Modalidad: 1 = Electrónica en Línea; 2 = Computarizada en Línea; 3 = Portal Web en Línea</li>
<li>Tipo de emisión: 1 = Online; 2 = Offline; 3 = Masiva</li>
<li>Tipo de factura: 1 = Factura con Derecho a Crédito Fiscal; 2 = Factura sin Derecho a Crédito Fiscal; 3 = Documento de Ajuste </li>
<li>Código del documento sector: Este código lo obtiene de la <a href="https://siatinfo.impuestos.gob.bo/index.php/facturacion-en-linea/implementacion-servicios-facturacion/sincronizacion-codigos-catalogos" target="_blank">API sincronización - Códigos de Tipo Documento Sector</a></li>
<li>Número de factura</li>
<li>Código del punto de venta: El código del punto de venta es definido en la <a target="_blank" href="https://siatinfo.impuestos.gob.bo/index.php/facturacion-en-linea/implementacion-servicios-facturacion/operaciones/registro-punto-de-venta">API operaciones - registro de punto de venta</a></li>
<li>Código de control: Este código se encuentra en la respuesta de la <a target="_blank" href="https://siatinfo.impuestos.gob.bo/index.php/facturacion-en-linea/implementacion-servicios-facturacion/codigos/solicitud-cufd">API código único de facturación diaria</a></li>
</ul>

```
Dado los siguientes datos:
· nit = 123456789
· date_time = 20190113163721231
· office = 0
· emission = 1
· type_invoice = 1
· modality = 1
· sector_document = 1
· invoice_number = 1
· point_of_sale: 0
· control_code: A19E23EF34124CD
```

```
Resultado:
8727F63A15F8976591FDDE5B387C5D015A29E06A1A19E23EF34124CD
```

### Uso técnico 🔧

Llame a la clase CufSiat, ingrese los datos solicitados, luego llame al metodo _generateCuf_.

```
use Arielfad\CufSiatBolivia\CufSiat;

$cuf = new CufSiat(123456789, 20190113163721231, 0,1,1,1,1,1,0,'A19E23EF34124CD');

return $cuf->generateCuf();
```

Para más información puede consultar con la guía del SIAT: https://siatinfo.impuestos.gob.bo/index.php/facturacion-en-linea/algoritmos-utilizados/generacion-cuf

Si quieres saber más acerca de los aspectos técnicos de facturación electrónica en línea no dudes en contactarte con mi persona.

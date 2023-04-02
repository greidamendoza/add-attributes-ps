## Agrega atributo y precio específico a Producto Prestashop

Script PHP que permite agregar atributo y precio específico de manera masiva a los productos de Prestashop a través de un archivo .csv

El archivo .csv debe contener el siguiente formato (usar como delimitador ;):

![alt text](https://github.com/greidamendoza/php-prestashop-addattributes/blob/main//assets/img/csv.png?raw=true)

### Descripción de campos:
**Id product:** ID de producto de Prestashop.
**Id attribute:** ID de atributo de Prestashop.
**Percentage Specific Price:** Porcentaje que se desea aplicar al precio del productop.
**Link:** Url de enlace personalizado a producto (módulo personalizado), no es obligatorio.

### Consideraciones:

- Inclusión de archivo de configuración para crear consultas al Core de Prestashop.
- En el archivo temp/ se guardan los .csv
- El producto debe estar activo en Prestashop.
- Si el atributo existe para el producto se omite el proceso.
- Se agrega a un almacén fijo llamado Central.
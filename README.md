## Instalación para hacer el Test de Grupo Todo

1.  Hacer un FORK del repo (no un clon)
2.  Copiar el .env como .env.local y cargar datos de la base mysql local
3.  composer install
4.  Correr migraciones
5.  php bin/console server:run 

## Despliegue de servics con Docker

Utilizando la herramienta Make

```shell
make run

# Una vez que el servicio de MySQL esté corriendo
make database
```
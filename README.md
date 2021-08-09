## Instalación para hacer el Test de Grupo Todo

1. Hacer un FORK del repo (no un clon)
2. Copiar el .env como .env.local y cargar datos de la base mysql local
3. composer install
4. Correr migraciones
5. php bin/console server:run

## Despliegue de servics con Docker

Descargar el proyecto y hacer copia del archivo **.env** como **.env.local** y **.env.test** como **.env.test.local**

En el archivo **.env.local** se debe reemplazar la variable de entorno DATABASE_URL

```shell
DATABASE_URL="mysql://root:grupotodo@database/grupotodo?serverVersion=8"
```

En el archivo **.env.test.local** se debe agregar la variable de entorno DATABASE_URL

```shell
DATABASE_URL="mysql://root:grupotodo@database/grupotodo?serverVersion=8"
```

Utilizando la herramienta Make

```shell
make run
```

Una vez que estén los servicios corriendo se deben generar las bases de datos del entorno **dev** y **test**. En el
archivo **.env.local** se reemplaza la variable de entorno **APP_ENV**.

```dotenv
# .env.local
APP_ENV=test
```

Y luego se ejecuta la creación de la base de datos.

```shell
make database
```

Se reemplaza nuevamente la variable de entorno **APP_ENV** en el archivo **.env.local**.

```dotenv
# .env.local
APP_ENV=dev
```

Y se ejecuta nuevamente la creación de la base de datos.

```shell
make database
```

Por último antes de iniciar las pruebas se pueden ejecutar los tests para comprobar el estado del desarrollo.

```shell
make tests
```
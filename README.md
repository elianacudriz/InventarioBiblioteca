# InventarioBiblioteca
Proyecto de clase ingenieria de Software

Bienvenido al manual de usuario de BiblioApp. Esta aplicación web permite gestionar el sistema de inventarios de una biblioteca. Permite agregar, prestar, retornar y descontinuar un libro. Este documento proporcionará una guía paso a paso para instalar y configurar la aplicación, así como instrucciones para su uso básico.

Aplicaciones requeridas:
Servidor web compatible (Xampp).
PHP versión [8.1] o superior.
MySQL versión [8.1] o superior.
Git instalado en su sistema.
GitHub.

Instalación
Se deben instalar todas las aplicaciones requeridas en su computador, a su vez, se deben crear las cuentas requeridas en cada aplicación de ser necesario.
Descargar del repositorio de BiblioApp desde GitHub. Para obtener la aplicación, primero debe clonar el repositorio de GitHub.
Navegue al directorio XAMPP/htdocs, que es la carpeta pública donde se debe almacenar la aplicación.
Haga click derecho dentro del directorio y seleccione la opción Git Bash here para abrir una terminal o línea de comandos.
Ejecute el siguiente comando: bash.
Ejecute el comando: git clone https://github.com/elianacudriz/InventarioBiblioteca.git
Configuración de la Base de Datos
Inicie sesión en su sistema de gestión de bases de datos (por ejemplo, MySQL).
Cuando esté allí, importe siguiente documento del cual se adjunta el link: 

https://drive.google.com/file/d/14xDQfaOOQ591-U6C3wqSjawm6LitZsHU/view?usp=drive_link
Inicio de la Aplicación
Dependiendo del entorno de la aplicación, puede necesitar iniciar un servidor local o configurar un servidor web virtual (XAMP/Apache).


Escriba en el navegador la siguiente dirección localhost/inventario.
Uso Básico
Luego de acceder a localhost/inventario la app iniciará.
Iniciar sesión
Introduzca el usuario (admin) y la contraseña (admin) establecidos.
Haga click en el botón iniciar sesión.
Navegar por la interfaz principal

Realizar Filtro de los libros o información de la tabla del DashBoard

Si desea puede ingresar un libro en el botón de la parte izquierda del aplicativo:
Ingresa el ISBN del libro
Ingrese el nombre del libro
Ingrese el autor del libro
Accionar el botón “Registrar”
Si desea puede prestar un libro en el botón de la parte derecha o izquierda del aplicativo:
Selecciona el libro que quiere prestar (puede buscarlo por ISBN)
Proporciona sus datos como prestador (CC, PA, CE, TI)
Acciona el botón “Enviar”
Acciona el botón cancelar en caso de querer cancelar la operación.
Si desea puede retornar un libro en el botón de la parte izquierda del aplicativo:
Ingresa ID del ticket. Si el usuario lo proporciona no es necesario ingresar el Id del libro ni ISBN
Ingresa ID del libro. Solo se ingresa en caso de que el usuario no proporcione el id del ticket
Ingresa ISBN  del libro. Solo se ingresa en caso de que el usuario no proporcione el id del ticket
Acciona el botón “Retornar”
Acciona el botón cancelar en caso de querer cancelar la operación.
Si desea puede descontinuar un libro en el botón de la parte izquierda del aplicativo:
Ingresa ID del libro 
Ingresa ISBN del libro y acciona el botón “Descontinuar libro”
Seguridad de la Cuenta

Este segmento del manual asegura que los usuarios estén informados sobre cómo la aplicación maneja la seguridad de las contraseñas y brinda consejos para que ellos mismos puedan contribuir a la seguridad de sus cuentas.

Es esencial que su información personal, especialmente su contraseña, permanezca segura y protegida. Para garantizar la seguridad de la información de acceso la aplicación utiliza el algoritmo MD5 para codificar las contraseñas de los usuarios antes de almacenarlas en la base de datos. Este método de codificación ayuda a asegurar que las contraseñas no se almacenan en texto plano, aumentando la seguridad contra accesos no autorizados.
Sobre el uso de MD5
Es importante mencionar que, aunque MD5 es un algoritmo de hash comúnmente utilizado, no se considera el más seguro para las contraseñas debido a su vulnerabilidad a ataques de colisión y su rapidez en el procesamiento, lo que facilita los ataques de fuerza bruta y los ataques de diccionario. Para una seguridad óptima, se recomendaría considerar algoritmos más robustos como bcrypt o Argon2.
Mejores Prácticas
Además de la codificación de contraseñas, es fundamental implementar medidas de seguridad adicionales como el uso de HTTPS, la implementación de tasas de límite para evitar ataques de fuerza bruta, y la utilización de autenticación de dos factores (2FA) para proporcionar una capa adicional de seguridad.





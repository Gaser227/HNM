1. Descomprimir el archivo .rar o .zip
2. "Instalar" la base de datos la cual, esta en el archivo base.bak
3. Configurar los archivos "Conexion.php" y "restauraciones.php". 
En el archivo Conexion, se configura lo siguiente:
Ln9     static private $user = "?"; Se especifica el nombre del usuario del servidor
Ln10    static private $host = "?"; Se especifica el servidor   
Ln11    static private $password = "?"; Se especifica la contraseña del usuario del servidor
Ln12    static private $dbname = "?" Se especifica el nombre de la base de datos
En el archibo restauraciones, se configura lo siguiente:
Ln7         $directorio = '?'; Se especifica la ruta donde se encuentran los respaldos
Ln 30       $rutaArchivo = '?' . $nombre; Se especifica la ruta donde se encuentran los respaldos
Ln33        $serverName = "?"; Se especifica el servidor 
Ln34        $dbname = "?"; Se especifica el nombre de la base de datos
Ln35        $username = "?"; Se especifica el nombre del usuario del servidor
Ln36        $password = "?"; Se especifica la contraseña del usuario del servidor

4. Iniciar sesion con las siguientes credenciales:
	Nomina: 555
	Contraseña: 123456789
5. Para realizar la operacion, se necesita ir a la seccion de base de datos, en la opcion de restauraciones, se mostraran los diversos archivos.

Simbologia:
? Donde se ingresa la informacion correspondiente del usuario.
Ln Linea del codigo donde se encuentra dicha instruccion.
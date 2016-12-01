<?php
/**
 * Connection.php
 * 
 * PHP version 5
 * 
 * @category BaseDatos
 * @package  CallCenter.Bd
 * @author   Ivan Tinajero <ivanetinajero@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://callcenter.sazacatecas.gob.mx
 */

/**
 * PHP version 5
 * 
 * @category Bd
 * @package  CallCenter.Bd
 * @author   Ivan Tinajero <ivanetinajero@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://callcenter.sazacatecas.gob.mx
 */
class Connection
{

    const SERVIDOR = 'localhost'; /* Sustituir por valor adecuado */
    const USUARIO = 'root'; /* Sustituir por valor adecuado */
    const CLAVE = 'admin'; /* Sustituir por valor adecuado */
    const BD = 'trello'; /* Nombre de la base de datos */

    private $_IdConexion;

    /**
    * Constructor de la clase
    */
    function __construct() 
    {
         $this->_IdConexion=mysqli_connect(self::SERVIDOR, self::USUARIO, self::CLAVE)
             or die('Imposible conectar con base de datos.');
         mysqli_select_db($this->_IdConexion, self::BD);
    }

    /**
    * Funcion para cerrar la conexion
    */
    function __destruct() 
    {
        mysqli_close($this->_IdConexion);
    }

    /**
    * Metodo para regresar una instancia de la conexion abierta
    * 
    * @return type
    */
    function getConexion() 
    {
         return $this->_IdConexion;
    }

}

?>

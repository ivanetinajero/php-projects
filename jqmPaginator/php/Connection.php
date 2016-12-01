<?php
/**
 * Connection.php
 * 
 * PHP version 5
 * 
 * @category BaseDatos
 * @package  jquerymobile.Bd
 * @author   Ivan Tinajero <ivanetinajero@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     
 */
class Connection
{

    const SERVER = 'localhost'; 
    const USER = 'root'; 
    const PASSWORD = 'admin'; 
    const DATABASE = 'jqmPaginator'; 

    private $_connection;

    /**
    * Constructor
    */
    function __construct() 
    {
         $this->_connection=mysqli_connect(self::SERVER, self::USER, self::PASSWORD)
             or die('There was a problem connecting database.');
         mysqli_select_db($this->_connection, self::DATABASE);
    }

    /**
    * Close connection
    */
    function __destruct() 
    {
        mysqli_close($this->_connection);
    }

    /**
    * Get the connection object
    * 
    * @return type
    */
    function getConnection() 
    {
         return $this->_connection;
    }

}

?>
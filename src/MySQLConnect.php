<?php
/**
* MySQLConnect: Model for database access
* @author G. Mizael Mtz Hdz
* @version 1.0.0
*/
class MySQLConnect
{
  /**
  * @var string $host DOMAIN/IP of the host
  * @var string $user Name of the user
  * @var string $password Password associed the user
  * @var string $db Name of the database
  * @var mixed $connection  Connection to the database (keep the state)
  */
  private $host="";
  private $user="";
  private $password="";
  private $db="";
  private $connection=null;
  /**
  * Constructor of the Class MySQLConnect: set the instance variables
  * @version 1.0
  * @return void
  */
  public function __construct()
  {
    $this->host="127.0.0.1";
    $this->user="root";
    $this->password="acer1";
    $this->db="notification";
  }
  /**
  * Connection to the database
  * @version 1.0
  * @return void
  */
  public function connection()
  {
    $this->connection=new mysqli($this->host,$this->user,$this->password,$this->db);
    if($this->connection->connect_error)
        die('Connect Error');
  }
  /**
  * Insert Data
  * @version 1.0
  * @param string $table table's name
  * @param array data: to insert
  * @return boolean
  */
  public function insert($table,$data)
  {
    $insert="INSERT INTO $table";
    $insert_fields="";
    $insert_values="";
    foreach($data as $key=>$value)
    {
      $insert_fields=$insert_fields.$key.',';
      $insert_values=$insert_values.$value.',';
    }
    $insert_fields=rtrim($insert_fields,",");
    $insert_values=rtrim($insert_values,",");
    $insert_fields='('.$insert_fields.')';
    $insert_values='('.$insert_values.')';
    $insert=$insert.$insert_fields.' VALUES'.$insert_values;
    return $this->connection->query($insert);
  }
  /**
  * Read data from database
  * @version 1.0
  * @param mixed $query
  * @param string $table
  * @param string $order_by
  * @param string $order
  * @return mixed
  */
  public function read($query=null,$table,$order_by=null,$order='ASC')
  {
    $result=array();

    if($query==null)
    {
      $str_order="";
      if($order_by!=null)
        $str_order="ORDER BY $order_by $order";
      $result=$this->connection->query("SELECT * FROM $table $str_order");
      #$result=$result->fetch_assoc()
      #$result=mysqli_fetch_all($result);
    }
    else
    {
      $result=$this->connection->query($query);
    }
    return $result;
  }
  /**
  * close connection
  * @version 1.0
  * @return void
  */
  public function close()
  {
    mysqli_close($this->connection);
  }
}
 ?>

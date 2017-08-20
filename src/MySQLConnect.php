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
    $this->host="";
    $this->user="";
    $this->password="";
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
  public function read($query=null,$table,$order_by=null,$order='ASC',$limit=array())
  {
    $result=array();

    if($query==null)
    {
      $str_order="";
      if($order_by!=null)
        $str_order="ORDER BY $order_by $order";
      $read="SELECT * FROM $table $str_order";
      if(!empty($limit))
      {
        $read=$read." LIMIT ".$limit["down"].",".$limit["up"];
      }
      $result=$this->connection->query($read);
      $result=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    else
    {
      $result=$this->connection->query($query);
      $result=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    return $result;
  }
  /**
  * Update data from database
  * @version 1.0
  * @param string $table
  * @param array $data
  * @param array $where
  * @return mixed
  */
  public function update($table,$data,$where)
  {
    $update="UPDATE $table SET ";
    foreach($data as $key=>$value)
    {
      $update=$update.$key.'='.$value.',';
    }
    $update=rtrim($update,",");
    $update=$update." WHERE ";
    foreach($where as $key=>$value)
    {
      $update=$update.$key.'='.$value." AND";
    }
    $update=rtrim($update,"AND");
    return $this->connection->query($update);
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

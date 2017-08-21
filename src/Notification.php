<?php
require_once 'MySQLConnect.php';
$result=array();
if(isset($_POST["action"]))
{
  switch($_POST["action"])
  {
    case "read":
      $con=new MySQLConnect();
      $con->connection();
      $limit=array();
      if(isset($_POST["block"]) && isset($_POST["segment"]))
      {
        $limit["down"]=0;
        $limit["up"]=$_POST["segment"];
        for($i=1;$i<$_POST["block"];$i++)
          $limit["down"]=$limit["down"]+$_POST["segment"];
      }
      $result=$con->read(null,"notification",null,null,$limit);
      $con->close();
    break;
    case "create":
      $date=date("Y-m-d H:i:s");
      $create=array();
      $con=new MySQLConnect();
      $con->connection();
      $create["date"]=$date;
      if(isset($_POST["title"]))
        $create["title"]=$_POST["title"];
      if(isset($_POST["message"]))
          $create["message"]=$_POST["message"];
      if(isset($_POST["url"]))
        $create["url"]=$_POST["url"];
      if(isset($_POST["readed"]))
        $create["readed"]=$_POST["readed"];
      if(isset($_POST["user_id"]))
        $create["user_id"]=$_POST["url"];
      $result=$con->insert("notification",$create);
      $con->close();
    break;
    case "update":
      $update=array();
      $where=array();
      if(isset($_POST["title"]))
        $update["title"]=$_POST["title"];
      if(isset($_POST["message"]))
          $update["message"]=$_POST["message"];
      if(isset($_POST["url"]))
        $update["url"]=$_POST["url"];
      if(isset($_POST["readed"]))
        $update["readed"]=$_POST["readed"];
      if(isset($_POST["user_id"]))
        $update["user_id"]=$_POST["url"];
      if(isset($_POST["idnotification"]))
        $where["idnotification"]=$_POST["idnotification"];
      $con=new MySQLConnect();
      $con->connection();
      $result=$con->update("notification",$update,$where);
      echo var_dump($result);
      $con->close();
    break;
  }
}
echo json_encode($result);
?>

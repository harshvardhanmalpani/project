<?php
class Registration{
    protected $conn;
    function __construct(){
        try{
            $this->conn=new mysqli("localhost","root","","sample");
        } catch(mysqli_sql_exception $e)
        {
            die("<h1>Connection to db failed</h1>");
        }
        
    }
    function tryRegister($name,$email,$password)
    {
        $user=$this->conn->prepare("select * from `userdata` where `email`= ?");
        $user->bind_param('s',$email);
        $user->execute();
        $res=$user->get_result();
        if($res->num_rows == 1)
            return "already registered<br>Go to <a href=index.htm>Login Page</a>";
        else
        {
            $user->close();
            $user=$this->conn->prepare("Insert into `userdata` (`name`,`email`,`password`) values (?,?,?)");
            $user->bind_param('sss',$name,$email,$password);
            $user->execute();
            if($this->conn->affected_rows ==1)
            { return "registration successful<br>Go to <a href=index.htm>Login Page</a>";}
            else return "registration failed<br>Please go back to <a href=register.htm>registration page</a>";
        }
    }
    function tryLogin($email,$password)
    {
        $finduser=$this->conn->prepare("select `id`, `name` from `userdata` where email= ? and password = ?");
        $finduser->bind_param('ss',$email,$password);
        $finduser->execute();
        $res=$finduser->get_result();
        if($res->num_rows ==1)
        {
            return $res->fetch_row();
        }
        else return false;
    }
}
?>
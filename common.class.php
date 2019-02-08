<?php
class Commonfunctions{
    private $salt="738e6%23((dhe))";
    function checkLoginInfo($b,$c){
        
        $this->b=$this->emailFilter($b);
        $this->c=$this->passwordFilter($c);
        return array($this->b,$this->c);
    }
    function checkInfo($a,$b,$c){
        
        $this->a=$this->nameFilter($a);
        $this->b=$this->emailFilter($b);
        $this->c=$this->passwordFilter($c);
        return array($this->a,$this->b,$this->c);
    }
    function nameFilter($a)
    {
        $b='';
    for($i=0;$i<strlen($a);$i++)
    {
        if(ctype_alpha($a[$i]) || $a[$i]===' ')
        {
            $b.=$a[$i];
        }
    }
    return $b;
        if(strlen($b)>1) return $b;
        else return false;
    }
    function emailFilter($email)
    {
        $n=filter_var($email,FILTER_SANITIZE_EMAIL);
        if(strlen($n)>3) return $n;
        else return false;
    }
    
    function passwordFilter($pass)
    {
        $n=filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW| FILTER_FLAG_STRIP_HIGH);
        if(strlen($n)>5) return $this->hashPass($n);
        else return false;
    }
    function hashPass($pass)
    {
        return crypt($pass . "ewur44d",$this->salt);
    }
    function forceBackend(){
        if(isset($_SESSION['loggedin']))
        {
            if($_SESSION['loggedin']=="success")
            {
                header("Location: secret.php");
                exit;
            }
        }
    }
    function forceLogin(){
        if($_SESSION['loggedin']!="success")
            {
                header("Location: index.htm");
                exit;
            }
    }
    function tryLogout(){
        if(isset($_SESSION['loggedin'])){
            session_unset();
            session_destroy();
            header("Location: index.htm");
        }
    }
}
?>
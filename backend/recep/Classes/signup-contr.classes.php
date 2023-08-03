<?php
class signupcontr extends signup{

    private $username;
    private $pwd;
    private $rpt_pwd;
    private $email;

    public function  __Constructor($username,$pwd,$rpt_pwd,$email){
        $this->username=$username;
        $this->pwd=$pwd;
        $this->rpt_pwd=$rpt_pwd;
        $this->email=$email;


    }
    public function signupuser(){
        if($this->emptyinput()==false){
            header("location:../user_registor.php?error=empty input");
        exit();
    
        }

        if($this->ivalidname()==false){
            header("location:../user_registor.php?error=invalid name");
        exit();
    
        }
        
        if($this->ivalidemail()==false){
            header("location:../user_registor.php?error=invalidemail");
        exit();
    
        }
        if($this->pwdmatch()==false){
            header("location:../user_registor.php?error=password missmatch");
        exit();
    
        }
        if($this-> CheckUser()==false){
            header("location:../user_registor.php?error=usernottaken");
        exit();
    
        }
         $this->setuser($username,$pwd,$rpt_pwd,$email);
      
    }

    public function emptyinput(){
        $result;
        if(empty($this->nusername)|| empty($this->pwd) || empty($this->rpt_pwd)||empty($this->email) ){
        return false;

    }
    else{
        return true;
    }
    return $result;
   }

   private function ivalidname(){
    $result;
    if(!preg_match("/*[a-zA-Z0-9]*$/",$thid->username)){
    return false;

}
else{
    return true;
}
return $result;
  
    }
    private function ivalidemail(){
        $result;
        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
        return false;
    
    }
    else{
        return true;
    }
    return $result;
      
        } 
        private function pwdmatch(){
            $result;
            if($this->pwd !== $this->rpt_pwd){
            return false;
        
        }
        else{
            return true;
        }
        return $result;
          
            }

            public function CheckUser($username,$email){
                $result;
                if($this->checkuser($this->username,$this->email)){
                return false;
            
            }
            else{
                return true;
            }
            return $result;
              
                }
} 





?>
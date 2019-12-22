<?php
class ProfileController
{
    public $db;       // Database Property
    public $url;      // Installation URL Property
    public $profile;
    

   /**
    * The authentication process
    *
    * @param int
    * @retrun mixed (Array || String)
    */
    function auth($type = null) 
    {
        if($type == 0) // $type 0: checks if the user is already logged-in
        {
            if(isset($_SESSION["phone_number"]) && isset($_SESSION["password"])) 
            {
                $tempProfile = new Profile();
                $tempProfile->phoneNumber = $_SESSION["phone_number"];
                $tempProfile->password = $_SESSION["password"];

                $this->profile = $tempProfile;

                $auth = $this->get();

                if($this->profile->password == $auth["password"]) 
                {
                    return $auth;
                } 
                else 
                {
                    $this->logout();
                    return "خطأ في رقم الهاتف أو كلمة مرور";
                }
            } 
        }
        else if($type == 1) // $type 1: log-in form process
        {
            $auth = $this->get();

            if(password_verify($this->profile->password, $auth["password"])) 
            {
                $_SESSION["phone_number"] = $auth["phone_number"];
                $_SESSION["password"] = $auth["password"];

                session_regenerate_id();

                return $auth;
            } 
            else 
            {
                return "خطأ في رقم الهاتف أو كلمة مرور";
            }
        }

        return false;
    }

    function get($type = null) 
    {
        // If the phone number input string is an e-mail, switch the query
        if(filter_var($this->db->real_escape_string($this->profile->phoneNumber), FILTER_VALIDATE_EMAIL)) 
        {
            $email = $this->db->real_escape_string($this->profile->phoneNumber);
            $query = sprintf("SELECT * FROM `profiles` WHERE `email` = '%s'", $email);
        } 
        else 
        {
            $phoneNumber = $this->db->real_escape_string($this->profile->phoneNumber);
            $query = sprintf("SELECT * FROM `profiles` WHERE `phone_number` = '%s'", $phoneNumber);
        }

        // If the query can't be executed (e.g: use of special characters in inputs)
        if(!$result = $this->db->query($query)) 
        {
            return 0;
        }

        $profile = $result->fetch_assoc();

        return $profile;
    }

    function process() 
    {
        $this->profile->managerName = filter_var($this->profile->managerName, FILTER_SANITIZE_STRING);
        
        // Must be stored in a variable before executing an empty condition
        $arr = $this->validateValues(); 

        // If there is no error message then execute the query;
        if(empty($arr)) 
        { 
            $this->profile->password = password_hash($this->profile->password, PASSWORD_DEFAULT);
            $query = $this->query();

            if($query) 
            {
                return $query;
            }

            // Set a session and log-in the user
            $_SESSION['phone_number'] = $this->profile->phoneNumber;
            $_SESSION['password']     = $this->profile->password;

            // Return (int) 1 if everything was validated
            $x = 1;
        } 
        else 
        { 
            // If there is an error message
            foreach($arr as $error) 
            {
                // Return the error value for translation file
                return notificationBox("alert alert-danger", $error, 1); 
            }
        }

        return $x;
    }

    function verifyIfPhoneNumberExist() 
    {
        $query = sprintf("SELECT `phone_number` FROM `profiles` WHERE `phone_number` = '%s'", $this->db->real_escape_string($this->profile->phoneNumber));
        $result = $this->db->query($query);

        return ($result->num_rows == 0) ? 0 : 1;
    }

    function validateValues() 
    {
        $error = array();
        $operators = array("010", "011", "012", "015");


        if($this->verifyIfPhoneNumberExist() !== 0) 
        {
            $error[] .= 'رقم الهاتف مستخدم بالفعل';
        }

        if(empty($this->profile->managerName) && 
           empty($this->profile->phoneNumber) && 
           empty($this->profile->password)) 
        {
            $error[] .= 'جميع الحقول مطلوبة';
        }

        if(strlen($this->profile->password) < 6) 
        {
            $error[] .= 'يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل';
        }

        if(!ctype_digit($this->profile->phoneNumber) || strlen($this->profile->phoneNumber) != 11) 
        {
            $error[] .= 'رقم الهاتف غير صحيح';
        }

        if(!in_array(substr($this->profile->phoneNumber, 0, 3), $operators)) 
        {
            $error[] .= 'رقم الهاتف غير مطابق لمشغلي شبكات المحمول في مصر';
        }

        if(strlen($this->profile->managerName) <= 5 || strlen($this->profile->managerName) >= 33) 
        {
            $error[] .= 'يجب أن يتراوح اسم مدير المتجر بين ٥ و ٣٣ حرفًا';
        }

        return $error;
    }

    function query() 
    {
        $query = sprintf("INSERT INTO `profiles` (`manager_name`, `phone_number`, `password`) VALUES ('%s', '%s', '%s');", $this->db->real_escape_string($this->profile->managerName), $this->db->real_escape_string($this->profile->phoneNumber), $this->profile->password);

        $this->db->query($query);
    }


    function logout($rt = null) 
    {
        unset($_SESSION["phone_number"]);
        unset($_SESSION["password"]);
        unset($_SESSION["token_id"]);
    }
}
?>
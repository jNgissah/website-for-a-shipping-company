<?PHP

  $connect    =   mysqli_connect("localhost","root","","shipping");
//$connect    =   mysqli_connect("localhost:3306","ravent13","@Ngissah1","ravent13_shipping");
//$connect=mysqli_connect("localhost","shopbjrc_shoponhype","@Ngissah1","shopbjrc_shipping");
$prayer_status=0;

session_start();

require 'PHPMailerAutoload.php';
$set=[0];
$mail=new PHPMailer;

$mail->Host='mail.zf1logistics.com';
$mail->Port=26;
$mail->SMTPAuth=true;
$mail->SMTPSecure='tls';
$mail->Username='order@ZF1logistics.com';
$mail->Password='order2020';

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}


if(isset($_POST['login'])){
    $user=$_POST['user'];
    $password= $_POST['password'];
//    echo $user;
//    echo $password;
    if($user=="username" && $password=="password"){
          $_SESSION['login']="yes";
        echo 1;
      
    }else{
        echo 0;
         $_SESSION['login']="no";
    }

    
}

if(isset($_POST['logged'])){
    if(isset($_SESSION['login'])){
        if($_SESSION['login']!=0){
          echo 'yes';  
        }else{
             echo 'no';
        }
    
    }else{
        echo 'no';
    }
    
}

if(isset($_POST['logout'])){
    $_SESSION['login']=0;
    
}

if(isset($_POST['getter'])){
   
    $get="SELECT `sender_surname`, `sender_firstname`, `sender_contact`, `sender_email`, `sender_address`, `sender_country`, `receiver_surname`, `receiver_firstname`, `receiver_contact`, `receiver_email`, `receiver_address`, `receiver_country`, `tracking_number`, `items`, `date`, `status`, `location`, `id`, `payment`, `payday` FROM `items`";
     $done= mysqli_query($connect,$get); 

    $row = mysqli_fetch_all($done);
    $row=json_encode($row);
    $_SESSION['data_']=$row;
    echo $_SESSION['data_'];
}


if(isset($_POST['getter_new'])){
   
    $get="SELECT `contact`,`location`, `status`, `date`, `id` FROM `contacts` ";
     $done= mysqli_query($connect,$get); 

    $row = mysqli_fetch_all($done);
    $row=json_encode($row);
    $_SESSION['data_new']=$row;
    echo $_SESSION['data_new'];
}

if(isset($_POST['status'])){
    
    $id=$_POST['id'];
    $value= $_POST['value'];
    $contact= $_POST['contact'];
    $tracking= $_POST['tracking'];
//    echo $id;
    $put="UPDATE `items` SET `status`='$value' WHERE `id`='$id' ";
    
    $done= mysqli_query($connect,$put); 

   if($done){
       echo 1;
       $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'NELOmTp7vF4n29Op6YfuLxJrm9wnfSh3x3RTXh1sX5QZe';
    $url = $endPoint . '?key=' . $apiKey;
    $data = [
       'recipient' => [''.$contact],
       'sender' => 'ZF1',
       'message' => 'Hi, your shipment with tracking number : '.$tracking.' is '.$value.'. Thank you for choosing ZF1. Visit https://www.zf1logistics.com for more information',
         'is_schedule' => 'false',
       'schedule_date' => ''
    ];

     $ch = curl_init();
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    $result = json_decode($result, TRUE);
    curl_close($ch);
//       print_r($result);
   }else{
       echo 2;
   }
}

if(isset($_POST['pay'])){
    
    $id=$_POST['id'];
    $value= $_POST['value'];
    $contact= $_POST['contact'];
    $paydate= $_POST['payday'];
    $tracking= $_POST['tracking'];
//    echo $id;
    $put="UPDATE `items` SET `payment`='$value', `payday`='$paydate' WHERE `id`='$id' ";
    
    $done= mysqli_query($connect,$put); 

   if($done){
       echo 1;
       $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'NELOmTp7vF4n29Op6YfuLxJrm9wnfSh3x3RTXh1sX5QZe';
    $url = $endPoint . '?key=' . $apiKey;
    $data = [
       'recipient' => [''.$contact],
       'sender' => 'ZF1',
       'message' => 'Hi, payment of USD '.$value.' has been made for your shipment with tracking number '.$tracking.'. Thank you for choosing ZF1. Visit https://www.zf1logistics.com for more information',
         'is_schedule' => 'false',
       'schedule_date' => ''
    ];

     $ch = curl_init();
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    $result = json_decode($result, TRUE);
    curl_close($ch);
//       print_r($result);
   }else{
       echo 2;
   }
}

if(isset($_POST['rated'])){
    
    $rate=$_POST['rate'];
    $select= $_POST['select'];
    echo $rate;
    $put="UPDATE `rate` SET `rate`='$rate'  WHERE `selected`='$select' ";
    
    $done= mysqli_query($connect,$put); 

   if($done){
       echo 1;
       
   }else{
       echo 2;
   }
}

if(isset($_POST['contact_us'])){
    
    $first=$_POST['firstname'];
    $last= $_POST['lastname'];
    $email= $_POST['email'];
    $message= $_POST['message'];

   
   if($message){
      
       
       
       
   }else{
       echo 2;
   }
}

if(isset($_POST['sms'])){

   $message=$_POST['message'];
   $get="SELECT `sender_surname`, `sender_firstname`, `sender_contact`, `sender_email`, `sender_address`, `sender_country`, `receiver_surname`, `receiver_firstname`, `receiver_contact`, `receiver_email`, `receiver_address`, `receiver_country`, `tracking_number`, `items`, `date`, `status`, `location`, `id`, `payment`, `payday` FROM `items`";

     $done1= mysqli_query($connect,$get); 
     $done= mysqli_fetch_all($done1, MYSQLI_ASSOC); 

    
    $result=unique_multidim_array($done, 'receiver_contact');
    $result=array_values($result);
    print_r($result);

        for($i=0; $i < count($result); $i++){
   array_push($set, $result[$i]['receiver_contact']);
        }
        
            

    $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'NELOmTp7vF4n29Op6YfuLxJrm9wnfSh3x3RTXh1sX5QZe';
    $url = $endPoint . '?key=' . $apiKey;
    $data = [
       'recipient' => $set,
       'sender' => 'ZF1',
       'message' => $message.' Visit https://www.zf1logistics.com for more information',
         'is_schedule' => 'false',
       'schedule_date' => ''
    ];

     $ch = curl_init();
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    $result = json_decode($result, TRUE);
    curl_close($ch);
//       print_r($result);  
    echo 1;

//        }
    
 
  
}

if(isset($_POST['add_contact'])){

    $contact=mysqli_real_escape_string($connect,  $_POST['contact']);
    $name=mysqli_real_escape_string($connect,  $_POST['name']);
    $qty=mysqli_real_escape_string($connect,  $_POST['qty']);
    $cbm=mysqli_real_escape_string($connect,  $_POST['cbm']);
    $track=mysqli_real_escape_string($connect,  $_POST['track']);
//    $sender_othername=mysqli_real_escape_string($connect,  $_POST['sender_othername']);
    $date=mysqli_real_escape_string($connect,  $_POST['date']);
    $location=mysqli_real_escape_string($connect,  $_POST['location']);
    $status="new";
    $add="INSERT INTO `contacts`(`contact`,`name`,`qty`,`cbm`,`track`, `location`, `status`, `date`) VALUES ('$contact','$name','$qty','$cbm','$track','$location','$status','$date')";
//    echo $add;
                                            
    $done= mysqli_query($connect,$add); 
    if($done){
        echo 1;
    }else{echo 0;
         }

}

if(isset($_POST['adder'])){
// echo "adder";
    $sender_surname=mysqli_real_escape_string($connect,  $_POST['sender_surname']);
//    $sender_othername=mysqli_real_escape_string($connect,  $_POST['sender_othername']);
    $sender_firstname=mysqli_real_escape_string($connect,  $_POST['sender_firstname']);
    $sender_contact=mysqli_real_escape_string($connect,  $_POST['sender_contact']);
    $sender_email=mysqli_real_escape_string($connect,  $_POST['sender_email']);
    $sender_country=mysqli_real_escape_string($connect,  $_POST['sender_country']);
    $sender_address=mysqli_real_escape_string($connect,  $_POST['sender_address']);
    $receiver_surname=mysqli_real_escape_string($connect,  $_POST['receiver_surname']);
//    $receiver_othername=mysqli_real_escape_string($connect,  $_POST['receiver_othername']);
    $receiver_firstname=mysqli_real_escape_string($connect,  $_POST['receiver_firstname']);
    $receiver_contact=mysqli_real_escape_string($connect,  $_POST['receiver_contact']);
    $receiver_email=mysqli_real_escape_string($connect,  $_POST['receiver_email']);
//    $receiver_region=mysqli_real_escape_string($connect,  $_POST['receiver_region']);
    $receiver_address=mysqli_real_escape_string($connect,  $_POST['receiver_address']);
//    $receiver_city=mysqli_real_escape_string($connect,  $_POST['receiver_city']);
    $receiver_country=mysqli_real_escape_string($connect,  $_POST['receiver_country']);
    $tracking=mysqli_real_escape_string($connect,  $_POST['tracking']);
    $item=mysqli_real_escape_string($connect,  $_POST['item']);
    $date=mysqli_real_escape_string($connect,  $_POST['date']);
    $id=mysqli_real_escape_string($connect,  $_POST['new_id']);
    $status="Sent to warehouse";
    $status2="old";
    $location="location";
    $payment="Unpaid";
    $payday="0";
    
    $add="INSERT INTO `items`(`sender_surname`, `sender_firstname`, `sender_contact`, `sender_email`, `sender_country`, `sender_address`, `receiver_surname`, `receiver_firstname`, `receiver_contact`, `receiver_email`,  `receiver_address`,  `receiver_country`, `tracking_number`, `items`,`date`, `status`, `location`, `payment`, `payday`) VALUES ('$sender_surname','$sender_firstname','$sender_contact','$sender_email','$sender_address','$sender_country','$receiver_surname','$receiver_firstname','$receiver_contact','$receiver_email','$receiver_address','$receiver_country','$tracking','$item','$date','$status','$location','$payment','$payday')";
//    echo $add;
                                            
    $done= mysqli_query($connect,$add); 
    if($done){
//        echo $id;
        $old="UPDATE `contacts` SET `status`='$status2' WHERE `id`='$id'";
        $cool=mysqli_query($connect,$old);
        if($cool){
            
        }
        
        echo 1;
        
        
    $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'NELOmTp7vF4n29Op6YfuLxJrm9wnfSh3x3RTXh1sX5QZe';
    $url = $endPoint . '?key=' . $apiKey;
    $data = [
       'recipient' => [''.$receiver_contact],
       'sender' => 'ZF1',
       'message' => 'Hi '.$receiver_firstname.', your shipment with tracking number: '.$tracking.' is '.$status.'. Thank you for choosing ZF1. Visit https://www.zf1logistics.com for more information',
         'is_schedule' => 'false',
       'schedule_date' => ''
    ];

    $ch = curl_init();
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    $result = json_decode($result, TRUE);
    curl_close($ch);

      print_r($result);  
        
    }

}

if(isset($_POST['edit'])){
// echo "adder";
    $sender_surname=mysqli_real_escape_string($connect,  $_POST['sender_surname']);
//    $sender_othername=mysqli_real_escape_string($connect,  $_POST['sender_othername']);
    $sender_firstname=mysqli_real_escape_string($connect,  $_POST['sender_firstname']);
    $sender_contact=mysqli_real_escape_string($connect,  $_POST['sender_contact']);
    $sender_email=mysqli_real_escape_string($connect,  $_POST['sender_email']);
    $sender_country=mysqli_real_escape_string($connect,  $_POST['sender_country']);
    $sender_address=mysqli_real_escape_string($connect,  $_POST['sender_address']);
    $receiver_surname=mysqli_real_escape_string($connect,  $_POST['receiver_surname']);
//    $receiver_othername=mysqli_real_escape_string($connect,  $_POST['receiver_othername']);
    $receiver_firstname=mysqli_real_escape_string($connect,  $_POST['receiver_firstname']);
    $receiver_contact=mysqli_real_escape_string($connect,  $_POST['receiver_contact']);
    $receiver_email=mysqli_real_escape_string($connect,  $_POST['receiver_email']);
//    $receiver_region=mysqli_real_escape_string($connect,  $_POST['receiver_region']);
    $receiver_address=mysqli_real_escape_string($connect,  $_POST['receiver_address']);
//    $receiver_city=mysqli_real_escape_string($connect,  $_POST['receiver_city']);
    $receiver_country=mysqli_real_escape_string($connect,  $_POST['receiver_country']);
    $tracking=mysqli_real_escape_string($connect,  $_POST['tracking']);
    $item=mysqli_real_escape_string($connect,  $_POST['item']);
    $date=mysqli_real_escape_string($connect,  $_POST['date']);
    $id=mysqli_real_escape_string($connect,  $_POST['new_id']);
    $status="Sent to warehouse";
    $status2="old";
    $location="location";
    $payment="Unpaid";
    $payday="0";
    
    $add="UPDATE `items` SET `sender_surname`='$sender_surname',`sender_firstname`='$sender_firstname',`sender_contact`='$sender_contact',`sender_email`='$sender_email',`sender_address`='$sender_address',`sender_country`='$sender_country',`receiver_surname`='$receiver_surname',`receiver_firstname`='$receiver_firstname',`receiver_contact`='$receiver_contact',`receiver_email`='$receiver_email',`receiver_address`='$receiver_address',`receiver_country`='$receiver_country',`items`='$item' WHERE `id` = '$id'";
//    echo $id;                                        
    $done= mysqli_query($connect,$add);
    
    if($done){

        echo 1;
        
    }else{
        echo 2;
    }

}




if(isset($_POST['get_rate'])){
   
    $getter="SELECT `rate`, `selected`, `id` FROM `rate`";
    $done_= mysqli_query($connect,$getter); 

    $row_ = mysqli_fetch_all($done_);
    $row_=json_encode($row_);
    $_SESSION['data_rate']=$row_;
    echo $_SESSION['data_rate'];
}












?>
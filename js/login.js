$(window).ready(function(){
    
    $("#login").submit(function(e){
     var user=$("#user").val()
     var password=$("#password").val()
     
     var fd = new FormData(); 
       fd.append("login",1)
       fd.append("user",user)
       fd.append("password",password)
      
     $.ajax({
            url: "phpmailer/input.php"
            , type: "POST"
            , async: false
            , data: fd
            , contentType: false
            , processData: false
            , success: function (data) {
                if(data==1){
                window.location.replace("https://zf1logistics.com/admin.html");

                }
                if(data==0){
                    swal("Login Error", "please check login credentials", "error");
                     $("#login")[0].reset()
                }
            }
        }) 
     
     
   })
      
    
       var fd = new FormData(); 
      
//    fd.append("logged",1)
//     $.ajax({
//            url: "phpmailer/input.php"
//            , type: "POST"
//            , async: true
//            , data: fd
//            , contentType: false
//            , processData: false
//            , success: function (data) {
//                console.log(data)
//                var currentLocation = window.location;
//                
//                if(data=="no"){
//                    window.location.replace("https://zf1logistics.com/login.html");
//                }
//            }
//        }) 
     
  
      
    
})
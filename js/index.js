$(document).ready(function(){
    console.log('printer')
    var close=function(){
        $('#printarea').hide()
    }
         $('.logout').click(function(e){
             var fd = new FormData(); 
      
    fd.append("logout",1)
     $.ajax({
            url: "phpmailer/input.php"
            , type: "POST"
            , async: true
            , data: fd
            , contentType: false
            , processData: false
            , success: function (data) {
              
            sessionStorage.clear()
            window.location.replace("https://zf1logistics.com/login.html");

       
            }
        }) 
     
            
      })
    
    $('.printer').click(function(e){
        $('#printarea').show()
            $('#printarea').printThis({
        debug: false,               // show the iframe for debugging
        importCSS: true,            // import parent page css
        importStyle: false,         // import style tags
        printContainer: true,       // print outer container/$.selector
        loadCSS: ["https://zf1logistics.com/css/materialize.css","https://zf1logistics.com/css/style.css"],                // path to additional css file - use an array [] for multiple
        pageTitle: "print",              // add title to print page
        removeInline: false,        // remove inline styles from print elements
        removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
        printDelay: 333,            // variable print delay
        header: null,               // prefix to html
        footer: null,               // postfix to html
        base: false,                // preserve the BASE tag or accept a string for the URL
        formValues: true,           // preserve input/form values
        canvas: false,              // copy canvas content
        doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
        removeScripts: false,       // remove script tags from print content
        copyTagClasses: false,      // copy classes from the html & body tag
        beforePrintEvent: null,     // callback function for printEvent in iframe
        beforePrint: null,          // function called before iframe is filled
        afterPrint: null            // function called before iframe is removed
            })
            // 
            // $('#printarea').hide()
        })
        
        
    
    
    
    
//    console.log('goooooooood')
    $('.track').click(function(e){
//        console.log($(e.target))
        var inner=$(e.target).text()
       $('.loader').show() 
        
    })
     $('.changes').click(function(e){
        console.log($(e.target))
        var inner=$(e.target).text()
        
        
    })
    
    
    
    
    
})
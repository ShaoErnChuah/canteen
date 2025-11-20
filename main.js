
    let subMenu=document.getElementById("subMenu");

    function togglemenu(){
        subMenu.classList.toggle("open-menu");
    }


    let eyeicon=document.getElementById("eye-icon");
let password=document.getElementById("password");
let password2=document.getElementById("cpassword");
eyeicon.onclick =function(){
   if(password.type == "password" ){
      password.type ="text";
   
      eyeicon.src="img/eye-open.png";
   }else{
      password.type ="password";
      eyeicon.src="img/eye-close.png";
   }
}




   var strength = {
      0: "Terrible",
      1: "Bad",
      2: "Weak",
      3: "Good",
      4: "Strong"
    }
    
    var password3 = document.getElementById('password');
    var meter = document.getElementById('password-strength-meter');
    var text = document.getElementById('password-strength-text');
    
    password3.addEventListener('input', function() {
      var val = password3.value;
      var result = zxcvbn(val);
    
      // Update the password strength meter
      meter.value = result.score;
    
      // Update the text indicator
      if (val !== "") {
        text.innerHTML = "Strength: " + strength[result.score]; 
      } else {
        text.innerHTML = "";
      }
    });
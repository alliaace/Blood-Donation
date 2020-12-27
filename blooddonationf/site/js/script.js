// JavaScript Document

function toggle(){

var regform=document.getElementById("reg");
var but = document.getElementById("switch");
var loginform=document.getElementById("login");
if(regform.style.display=="block"&&loginform.style.display=="none"){
	regform.style.display="none";
	loginform.style.display="block";
	check=false;
	but.innerHTML="Dont have an account? Register";
}else{
	regform.style.display="block";
	loginform.style.display="none";
	check=true;
	but.innerHTML="Have an acoount? Sign In";
}

}

function reg(){	
var form= [
document.getElementById("reg_fname"),
document.getElementById("reg_lname"),
document.getElementById("reg_username"),
document.getElementById("reg_email"),
document.getElementById("reg_gender"),
document.getElementById("reg_password")
];
var hr= new XMLHttpRequest();
var par="fname="+form[0].value+"&lname="+form[1].value+"&username="+form[2].value+"&email="+form[3].value+"&gender="+form[4].value+"&password="+form[5].value;
if(!(form[0].value==""||form[1].value==""||form[2].value==""||form[3].value==""||form[4].value=="Genders"||form[5].value=="")){
	//put your security checks here
	hr.open("POST","../php/register.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			var data = JSON.parse(hr.responseText);
				if(!data["error"]){
				 alert("done");
				}else{
					alert(data["error_msg"]);
				}
	    }
    }
    hr.send(par);
//end here
}else{
high_incorrectfield(form);

}

	//alert(" "+fname+ " "+lname+ " "+username+ " "+gender+ " "+email+ " "+password+ " ");


}
function log_in(){
	var form= [
document.getElementById("login_email"),
document.getElementById("login_password")
];
var hr= new XMLHttpRequest();
var par="email="+form[0].value+"&password="+form[1].value+"&device=web";
if(!(form[0].value==""||form[1].value=="")){
	//put your security checks here
	hr.open("POST","../php/login.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	 hr.onreadystatechange = function() {
	   
		if(hr.readyState == 4 && hr.status == 200) {
			//alert(hr.responseText);
			var data = JSON.parse(hr.responseText);
				if(!data["error"]){
					document.location.reload();
				}else{
					alert(data["error_msg"]);
				}
	    }
    }
    hr.send(par);
	//end here

}else{
	high_incorrectfield( form);
}
}

function high_incorrectfield( form){
	for (i = 0; i < form.length; i++) {
    if(form[i].value==""||form[i].value=="Genders"){
		form[i].style.borderColor="red";
	}else{
		form[i].style.borderColor="#555";
	}
	}
}


	
function save(choice,oldvalue,id){
	var form =[
	document.getElementById("fname"),
	document.getElementById("lname"),
	document.getElementById("username"),
	document.getElementById("email"),
	document.getElementById("bloodgroup"),
	document.getElementById("phone")
	];
	var files =[
	"../php/includes/db_fields/fname.php",
	"../php/includes/db_fields/lname.php",
	"../php/includes/db_fields/username.php",
	"../php/includes/db_fields/email.php",
	"../php/includes/db_fields/bloodgroup.php",
	"../php/includes/db_fields/phone.php",
	];
	var hr= new XMLHttpRequest();
var par="id="+id+"&value="+form[choice].value+"&device=web";
if(!(form[choice].value==""||form[choice].value==oldvalue)){
	//put mocheck starting from here
	
	hr.open("POST",files[choice],true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			//alert(hr.responseText);
			var data = JSON.parse(hr.responseText);
				if(data["error"]){
					alert(data["error_msg"]);
				}else{
					document.location.reload()
				}
	    }
    }
    hr.send(par);
	//end your checks herere
}
//alert(form[choice].value+":"+oldvalue);
}
function hidepassword(){
	document.getElementById("overlay").style.visibility="hidden";
		document.getElementById("passwordform").style.visibility="hidden";
}function showpassword(){
	document.getElementById("overlay").style.visibility="visible";
		document.getElementById("passwordform").style.visibility="visible";
}
function changepass(id){
	var hr= new XMLHttpRequest();
	var form =[
	document.getElementById("oldpassword"),
	document.getElementById("newpassword"),
	document.getElementById("repeatnewpassword"),
	];
	var par="id="+id+"&old="+form[0].value+"&new="+form[1].value+"&device=web";
	if(!(form[0].value==""||form[1].value==""||form[2].value=="")){
		if(form[1].value==form[2].value){
		hr.open("POST","../php/includes/db_fields/password.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			//alert(hr.responseText);
			var data = JSON.parse(hr.responseText);
				if(data["error"]){
					alert(data["error_msg"]);
				}else{
					document.location.reload()
				}
	    }
    }
    hr.send(par);
		//alert(par);
		}else{
			alert("repeated password did not match");
		}
	}else{
		alert("imformation missing!");
	}
}
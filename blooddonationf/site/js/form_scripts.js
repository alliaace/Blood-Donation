// JavaScript Document
function post(id){
	var val=[
	document.getElementById("bloodgroup").value,
	document.getElementById("peoplerequired").value
	];
	var hr= new XMLHttpRequest();
	var par="recipient_id="+id+"&bloodgroup="+val[0]+"&reqpeople="+val[1]+"&device=web";
if(!(val[0]==""||val[1]=="")){
	//put mocheck starting from here
	hr.open("POST","../php/adpost.php",true);
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
}

function optionnavigator(choice,userid){
	var contentbody= document.getElementById("mycontentbod");
	var buts=[
	document.getElementById("myads"),	
	document.getElementById("myrequests"),	
	];	
	var pages=["myads.php","myreqs.php"];
	optionHighlight(choice, buts);
	var hr = new XMLHttpRequest();
    hr.open("POST",pages[choice] , true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded", true);
    hr.onreadystatechange = function() {
	    console.log(hr.responseText);
		if(hr.readyState == 4 && hr.status == 200) {
			contentbody.innerHTML =   hr.responseText;			
	    }
    }
    hr.send("reqby="+userid);

}
function hidereqdialogue(){
	document.getElementById("overlay").style.visibility="hidden";
		document.getElementById("requestsdialogue").style.visibility="hidden";
}function showreqdialogue(){
	document.getElementById("overlay").style.visibility="visible";
		document.getElementById("requestsdialogue").style.visibility="visible";
}
function hidecontactdialogue(){
	document.getElementById("overlay").style.visibility="hidden";
		document.getElementById("contactdialogue").style.visibility="hidden";
}function showcontactdialogue(){
	document.getElementById("overlay").style.visibility="visible";
		document.getElementById("contactdialogue").style.visibility="visible";
}

function optionHighlight(choice, buts){
	for(var i=0;i<buts.length;i++){
		buts[i].classList.remove("spanselected");
	}
	buts[choice].classList.add("spanselected");
}
function showreqs(ad_id){
		var contentbody= document.getElementById("mycontentbod");
	var hr = new XMLHttpRequest();
    hr.open("POST","requests.php" , true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded", true);
    hr.onreadystatechange = function() {
	    console.log(hr.responseText);
		if(hr.readyState == 4 && hr.status == 200) {
			showreqdialogue();
			document.getElementById("requestsdialogue").innerHTML =   '<span style="border-bottom:1px solid #ccc;width:100%;display:inline-block;text-align:center; font-size:22px; padding:10px;">Requests</span><br>'+hr.responseText+'<div style="text-align:center;padding-top:10px;"><button class="but_red" onclick=" hidereqdialogue()">close</button></div>';			
	    	
		}
    }
    hr.send("ad_id="+ad_id);
}
function accpetreq(reqid,elem){
elem=elem.parentNode;
var hr = new XMLHttpRequest();
    hr.open("POST","../php/adpost.php" , true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded", true);
    hr.onreadystatechange = function() {
	 
		var data=JSON.parse(hr.responseText);
		console.log(hr.responseText);
		if(hr.readyState == 4 && hr.status == 200) {
			if(data["error"]){
				alert(data["error_msg"]);
			}else{
				elem.innerHTML='<span style="text-align:center;font-size:18px;">email:'+data["contact_email"]+'<br>phone:'+data["contact_phone"]+'</span>';
			}
		}
    }
    hr.send("actiononreq=acc&req_id="+reqid);
}
function rejectreq(reqid,elem){
elem=elem.parentNode;
var hr = new XMLHttpRequest();
    hr.open("POST","../php/adpost.php" , true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded", true);
    hr.onreadystatechange = function() {
	    console.log(hr.responseText);
		var data=JSON.parse(hr.responseText);
		if(hr.readyState == 4 && hr.status == 200) {
			if(data["error"]){
				alert(data["error_msg"]);
			}else{
				elem.innerHTML="<span style='text-align:center'>rejected</span>";
			}
		}
    }
    hr.send("actiononreq=rej&req_id="+reqid);	
}
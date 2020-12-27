function loadfeed(id){
var hr= new XMLHttpRequest();
var name ="a";
	//put mocheck starting from here
	hr.open("POST","../php/adpost.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			//console.log(hr.responseText);
			var data = JSON.parse(hr.responseText);
			var datalength = Object.keys(data).length
			//alert(data["error"]);
				if(data["error"]){
					document.getElementById("content").innerHTML +='<div style="text-align:center; padding-top:30px; font-size:36px;">'+data["error_msg"]+'</div>';
				}else{
					//alert(datalength);
					for(var i=0;i<datalength;i++){
					document.getElementById("content").innerHTML +='<div class="'+(data[i]["recipient_userid"]==id?"adcontainer_red":"adcontainer")+'"><table style="width:900px; margin:0 auto;"><tr><td><div class="dp"></div></td><td style="padding-left:10px ; width:300px;"><span style="font-size:24px">'+(data[i]["recipient_userid"]==id?"you":data[i]["recipient_fname"]+' '+data[i]["recipient_lname"])+'</span></td><td style="padding-left:20px;width:150px; "><span style="font-size:18px">Required blood group: <b>'+data[i]["bloodgroup"]+'</b></span></td><td style="padding-left:20px; width:150px;"><span style="font-size:18px">People needed: <br><b>'+(data[i]["totalneed"]-data[i]["remaningpeople"])+' of '+data[i]["totalneed"]+'</b></span></td><td style="padding-left:20px;width:150px;"><span style="font-size:18px">Ad given: <br ><b style="font-size:16px">'+data[i]["postdate"]+' ago</b></span></td><td style="padding-left:10px; ">'+(data[i]["recipient_userid"]==id?'<button id="delete" class="but_red" onclick="deletead('+data[i]["id"]+','+data[i]["recipient_userid"]+')" >  Delete </button>':'<button id="donate" class="but_red" onclick="donate('+data[i]["id"]+','+id+',this)" '+(data[i]["apllied"]==1?"disabled":"")+'>Donate</button>')+'</td></tr></table></div>';
					}
				}
	    }
    }
    hr.send("getads=active&reqby="+id);
	//end your checks herere
}
function ago(time){
	var then = new Date(time);
	var now=new Date();
	var p="";
	var out;
	//console.log(then +" : " +now);
	if(now.getDate()-then.getDate()>0){
		if(now.getDate()-then.getDate()>1){
			p="s";
		}
		out=now.getDate()-then.getDate()+" day"+p;
	}else if(now.getHours()-then.getHours()>0){
		if(now.getHours()-then.getHours()>1){
			p="s";
		}
		out=now.getHours()-then.getHours()+" hour"+p;
	}else if(now.getMinutes()-then.getMinutes()>1){
			
			out=now.getMinutes()-then.getMinutes()+" minute"+p;
	}else{
			out="1 minute";
	}
	return out;
}
function deletead(id,uid){
	var hr= new XMLHttpRequest();
	hr.open("POST","../php/adpost.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			//console.log(hr.responseText);
			var data = JSON.parse(hr.responseText);
			//alert(data["error"]);
				if(data["error"]){
					alert(data["error_msg"]);				
				}else{
					//alert(datalength);
					document.location.reload();
				}
	    }
    }
	
    hr.send("deletead="+id+"&reqby="+uid);
}
function donate(id,uid,source){
var hr= new XMLHttpRequest();
	//put mocheck starting from here
	hr.open("POST","../php/donate.php",true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			//console.log(hr.responseText);
			var data = JSON.parse(hr.responseText);
			//alert(data["error"]);
				if(data["error"]){
					alert(data["error_msg"]);				
				}
	    }
    }
    hr.send("ad_id="+id+"&requestby="+uid);
	//alert(arguments.callee.caller.toString());
	source.disabled=true;
	//console.log(source);
}
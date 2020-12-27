
function navigator(choice,userid){
	var contentbody= document.getElementById("contentBody");
	var buts=[
	document.getElementById("adform"),	
	document.getElementById("feed"),	
	document.getElementById("profile")
	];	
	var pages=["adform.php","feed.php","profile.php"];
	navHighlight(choice, buts)
	var hr = new XMLHttpRequest();
    hr.open("GET",pages[choice] , true);
    hr.setRequestHeader("Content-type", "text/html", true);
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
			contentbody.innerHTML =   hr.responseText;			
	    }
    }
    hr.send(null);
	if(choice==1)
	{
		loadfeed(userid);
	}else if(choice==0)
	{
		optionnavigator(0,userid);
	}
}
function navHighlight(choice, buts){
	for(var i=0;i<buts.length;i++){
		buts[i].classList.remove("navs_selected");
	}
	buts[choice].classList.add("navs_selected");
}
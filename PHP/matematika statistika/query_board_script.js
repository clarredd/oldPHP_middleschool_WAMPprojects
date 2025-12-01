this.onload=function(){
	var all_details=document.getElementsByTagName("details");
	console.assert(all_details.length===1);
	var detail=all_details[0];
	//delete all_details;
	all_details=undefined;
	detail.ontoggle=function(){
		var is_open=detail.open;//detail.hasAttribute("open");
		if(is_open)
			document.cookie="detail_open=yes;";
		else
			document.cookie="detail_open=not;";
		//console.log(document.cookie);
	};
	if(document.cookie.includes("detail_open=yes;"))
		detail.open=true;
}

//Small problem: the cookie is applied too all query boards. 
//Solution: The PHP script makes another script tag that sets a index variable, which is used by this script;
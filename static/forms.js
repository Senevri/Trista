function showhide(){
	var passu = document.getElementById('pwd');
	if (passu.type=="password"){ 
		passu.type="text";
	} else { 
		passu.type="password";
	}
}
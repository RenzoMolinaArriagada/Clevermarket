require('./bootstrap');

require('alpinejs');

$('#content').on('click','#sidebarCollapse',function(){
	event.preventDefault();
	if($('#sidebar').hasClass("active")){
		$('#sidebar').removeClass("active")
	}
	else{
		$('#sidebar').addClass("active")
	}

});
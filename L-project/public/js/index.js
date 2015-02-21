console.log('index.js LOADED');

function about_us(){
	$('#index-switcher-aboutus').show();
	$('#index-switcher-register').hide();
	$('#index-switcher-register-doc').hide();
	$('#index-switcher-login').hide();
}

function login(){
	$('#index-switcher-login').show();
	$('#index-switcher-register-doc').hide();
	$('#index-switcher-register').hide();
	$('#index-switcher-aboutus').hide();
}

function register(){
	$('#index-switcher-register').show();
	$('#index-switcher-register-doc').show();
	$('#index-switcher-login').hide();
	$('#index-switcher-aboutus').hide();
}

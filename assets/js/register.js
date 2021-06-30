$(document).ready(function() {
	// On click sign up, hide login an d show registration form
	$("#signup").click(function() {
		$("#first").slideUp("slow", function() {
			$("#second").slideDown("slow");
		});
	}); // id: #, class.

	// On click sign up, hide registration an d show login form
	$("#signin").click(function() {
		$("#second").slideUp("slow", function() {
			$("#first").slideDown("slow");
		});
	}); 

});
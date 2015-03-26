$(document).ajaxComplete(function (event, xhr) {
	if(xhr.responseText && JSON.parse(xhr.responseText).authentication == 'failed'){
		window.location.hash = '/logout';
	}
});

Sammy(function () {

	this._checkFormSubmission = function () {
		return false;
	};

	this.get('#/register', function () {
		vm.loggedIn(false);
		vm.currentView('register');
	});

	this.get('#/login', function () {
		vm.loggedIn(false);
		vm.currentView('login');
	});

	this.get('#/logout', function () {
		$.cookie('auth', null);
		vm.loggedIn(false);
		window.location.hash = '/login';
	});

	this.get('#/shows', function () {
		vm.currentView('shows');

		$.ajax({
			url: '/tv-index/api/auth',
			beforeSend: function (xhr) {
				xhr.setRequestHeader("Auth", $.cookie("auth"));
			}
		});
	});

	this.get('#/search', function () {
		vm.currentView('search');
	});

}).run('#/login');
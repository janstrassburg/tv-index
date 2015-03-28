App.Router = {
	run: function(route){
		Sammy(function () {
			var nav = App.ViewModel.Navigation;

			this._checkFormSubmission = function () {
				return false;
			};

			this.get('#/register', function () {
				nav.loggedIn(false);
				nav.currentView('register');
			});

			this.get('#/login', function () {
				nav.loggedIn(false);
				nav.currentView('login');
			});

			this.get('#/logout', function () {
				$.cookie('auth', null);
				nav.loggedIn(false);
				window.location.hash = '/login';
			});

			this.get('#/shows', function () {
				nav.currentView('shows');

				$.ajax({
					url: '/tv-index/api/auth',
					beforeSend: function (xhr) {
						xhr.setRequestHeader("Auth", $.cookie("auth"));
					}
				});
			});

			this.get('#/search', function () {
				nav.currentView('search');
			});

		}).run(route);
	}
};

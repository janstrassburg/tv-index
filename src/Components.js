App.Components = {
	register: function () {
		ko.components.register('login-form', {
			viewModel: {instance: App.ViewModel.LoginForm},
			template: {element: 'login-form'}
		});

		ko.components.register('search-results', {
			viewModel: {instance: App.ViewModel.SearchResults},
			template: {element: 'search-results'}
		});

		ko.components.register('register-form', {
			viewModel: {instance: App.ViewModel.RegisterForm},
			template: {element: 'register-form'}
		});
	}
};

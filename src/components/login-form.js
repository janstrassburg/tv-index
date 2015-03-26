ko.components.register('login-form', {
	viewModel: function () {
		var self = this;
		self.isSubmitting = false;

		self.form = {
			email: ko.observable(''),
			password: ko.observable('')
		};

		self.onSubmit = function () {
			if (!self.isSubmitting) {
				self.submitForm();
			}
		};

		self.submitForm = function () {
			self.isSubmitting = true;
			var request = $.ajax({
				url: "/tv-index/api/login",
				method: "POST",
				data: ko.toJSON(self.form),
				contentType: "application/json"
			});
			request.done(function (response) {
				if (response.success) {
					$.cookie("auth", JSON.stringify(response.auth));
					vm.loggedIn(true);
					window.location.hash = window.location.hash = '/shows';
				} else {
					self.isSubmitting = false;
				}
			});
		};
	},

	template: {element: 'login-form'}
});
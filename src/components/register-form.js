ko.components.register('register-form', {
	viewModel: function () {
		var self = this;

		self.form = {
			firstName: ko.observable().extend({required: true}),
			lastName: ko.observable().extend({required: true}),
			email: ko.observable().extend({required: true, email: true}),
			password: ko.observable().extend({passwordComplexity: true}),
			confirmPassword: ko.observable()
		};
		self.form.confirmPassword.extend({equal: self.form.password})

		self.isSubmitting = false;
		self.onSubmit = function () {
			var form = ko.validatedObservable(self.form);
			if (!self.isSubmitting && form.isValid()) {
				self.submitForm();
			} else {
				form.errors.showAllMessages(true);
			}
		};

		self.submitForm = function () {
			self.isSubmitting = true;
			var request = $.ajax({
				url: "/tv-index/api/register",
				method: "POST",
				data: ko.toJSON(self.form),
				contentType: "application/json"
			});
			request.done(function (response) {
				if (response.success) {
					window.location.hash = '/login';
				} else {
					self.isSubmitting = false;
				}
			});
		};
	},

	template: {element: 'register-form'}
});
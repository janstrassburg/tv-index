App.ViewModel.RegisterForm = {
	isSubmitting: false,

	form: App.Form.Register,

	onSubmit: function () {
		var form = ko.validatedObservable(this.form);
		if (!this.isSubmitting && form.isValid()) {
			this.submitForm();
		} else {
			form.errors.showAllMessages(true);
		}
	},

	submitForm: function () {
		var self = this;
		this.isSubmitting = true;
		var request = $.ajax({
			url: "/tv-index/api/register",
			method: "POST",
			data: ko.toJSON(this.form),
			contentType: "application/json"
		});
		request.done(function (response) {
			if (response.success) {
				window.location.hash = '/login';
			} else {
				self.isSubmitting = false;
			}
		});
	}
};

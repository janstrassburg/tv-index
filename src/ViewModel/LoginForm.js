App.ViewModel.LoginForm = {
	isSubmitting: false,

	form: App.Form.Login,

	onSubmit: function () {
		if (!this.isSubmitting) {
			this.submitForm();
		}
	},

	submitForm: function () {
		var self = this;
		this.isSubmitting = true;

		var request = $.ajax({
			url: "/tv-index/api/login",
			method: "POST",
			data: ko.toJSON(this.form),
			contentType: "application/json"
		});

		request.done(function (response) {
			if (response.success) {
				$.cookie("auth", JSON.stringify(response.auth));
				App.ViewModel.Navigation.loggedIn(true);
				window.location.hash = '/shows';
			} else {
				self.isSubmitting = false;
			}
		});
	}
};

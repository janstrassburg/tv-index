App.Form.Register = {
	firstName: ko.observable().extend({required: true}),
	lastName: ko.observable().extend({required: true}),
	email: ko.observable().extend({required: true, email: true}),
	password: ko.observable().extend({passwordComplexity: true}),
	confirmPassword: ko.observable()
};

App.Form.Register.confirmPassword.extend({
	areSame: {
		params: App.Form.Register.password,
		message: "Confirm password must match password"
	}
});
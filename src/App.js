App = {
	Router: {},
	Components: {},
	ViewModel: {},
	Form: {}
};

$(document).ajaxComplete(function (event, xhr) {
	if (xhr.responseText &&
		JSON.parse(xhr.responseText).authentication == 'failed'
	) {
		window.location.hash = '/logout';
	}
});

$(function () {
	App.Components.register();
	App.Router.run('#/login');
	ko.applyBindings(App.ViewModel.Navigation);
});
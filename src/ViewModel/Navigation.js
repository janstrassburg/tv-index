App.ViewModel.Navigation = {
	currentView: ko.observable(),
	loggedIn: ko.observable(true),
	searchTerm: ko.observable(),

	search: function () {
		window.location.hash = '/search/'+this.searchTerm();
	}
};

function AppViewModel() {
	var self = this;
	self.currentView = ko.observable();
	self.loggedIn = ko.observable(true);
	self.searchTerm = ko.observable();

	self.search = function () {
		var request = $.ajax({
			url: "/tv-index/api/search/" + self.searchTerm(),
			contentType: "application/json",
			beforeSend: function (xhr) {
				xhr.setRequestHeader("Auth", $.cookie("auth"));
			}
		});
		request.done(function (response) {
			searchResultsViewModel.shows.removeAll();
			ko.utils.arrayPushAll(searchResultsViewModel.shows, response);
			window.location.hash = '/search';
		});
	};
}

var vm = new AppViewModel();
ko.applyBindings(vm);
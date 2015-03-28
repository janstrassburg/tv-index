App.ViewModel.Navigation = {
	currentView: ko.observable(),
	loggedIn: ko.observable(true),
	searchTerm: ko.observable(),

	search: function () {
		var request = $.ajax({
			url: "/tv-index/api/search/" + this.searchTerm(),
			contentType: "application/json",
			beforeSend: function (xhr) {
				xhr.setRequestHeader("Auth", $.cookie("auth"));
			}
		});
		request.done(function (response) {
			App.ViewModel.SearchResults.shows.removeAll();
			ko.utils.arrayPushAll(App.ViewModel.SearchResults.shows, response);
			window.location.hash = '/search';
		});
	}
};

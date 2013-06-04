/*
  Developed by: Digital Dealers
	Author: @vampaynani
	URL: digitaldealers.mx
	Description: Script to generate an array from a Twitter feed/wall.
*/

function TwitterWall() {
	var DDTW = this, 
		loadedObjs = {}, opts = {},accessToken = '', months = [];
	var defMonths = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre","Noviembre", "Diciembre");
	this.ASC = 'Ascending';
	this.DESC = 'Descending';
	this.app = {};
	this.ids = [];
	this.feed = [];
	this.options = {
		limit: 10
	};
	this.init = function () {
		var constructor = arguments[0];
		DDTW.ids = constructor.ids;
		DDTW.months = constructor.months || defMonths;
		$(DDTW).trigger('initialized');
	}
	this.getAllTLs = function () {
		DDTW.opts = arguments[0];
		for (var id in DDTW.ids) {
			DDTW.getTimeline(DDTW.ids[id]);
			loadedObjs[DDTW.ids[id]] = false;
		}
		$(DDTW).on('tlLoaded', function (e) {
			$(DDTW).off('tlLoaded');
			loadedObjs[e.id] = true;
			for (var obj in loadedObjs) {
				if (loadedObjs[obj] === false)
					return;
			}
			$(DDTW).trigger('allLoaded');
		})
	}
	this.getTimeline = function () {
		var userID = arguments[0];
		var limit = DDTW.opts.limit || DDTW.options.limit;
		$.get(
			'https://api.twitter.com/1/statuses/user_timeline.json', {
				screen_name: userID,
				rpp: limit
			}, function (response) {
				for (result in response) {
					var obj = new Object;
					var res = response[result];
					var d = new Date(res.created_at);
					var curr_dias = d.getDate(),
						curr_mess = months[d.getMonth()],
						curr_years = d.getFullYear(),
						curr_horas = DDTW.addZero(d.getHours()),
						curr_minutoss = DDTW.addZero(d.getMinutes());
					var dString = (curr_dias + " de " +
						curr_mess + " de " + curr_years +
						" a las " + curr_horas + ":" +
						curr_minutoss);
					obj.created_time = dString;
					obj.from = {
						name: res.user.name
					};
					obj.picture = res.user.profile_image_url;
					obj.message = res.text;
					obj.type = 'text';
					obj.network = 'tw';
					DDTW.feed.push(obj);
				}
				$(DDTW).trigger({
						type: 'tlLoaded',
						id: userID
					});
			}, 'jsonp');
	}
	this.addZero = function (i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
}

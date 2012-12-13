//===== General Vars =======
var username = 'username';
var twitnumber = '0';
//======================

$(document).on('ready', function(){
	$.get('https://api.twitter.com/1/statuses/user_timeline.json', {'screen_name':username, 'count':twitnumber}, function(data){
		$.each(data, function(index, item) {
			$('#twitter-list').append(item.screen_name + ": " + item.text);
		})
	}, "jsonp");
});
class Twitterlist
	OAUTH_URL: 'https://api.twitter.com/oauth2/token'
	constructor: (consumerKey, consumerSecret) ->
		@coder = new Base64()
		@key = @_fixedEncodeURIComponent consumerKey
		@secret = @_fixedEncodeURIComponent  consumerSecret
		@bearerToken = "#{@key}:#{@secret}"
		@bearerEncoded = @coder.encode @bearerToken
		console.log @bearerEncoded
		@_requestCredentials()
	_requestCredentials: ->
		$.ajax 
			url: @OAUTH_URL
			type: "POST"
			crossDomain: true
			data: 
				grant_type: 'client_credentials' 
			dataType: 'json'
			beforeSend: (xhr) =>
				xhr.setRequestHeader 'Authorization', "Basic #{@bearerEncoded}"
		false
	_fixedEncodeURIComponent: (str) ->
    	encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A")
    window.Twitterlist = Twitterlist
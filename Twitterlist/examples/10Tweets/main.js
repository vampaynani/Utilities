require.config({
    urlArgs: "bust=" + (new Date()).getTime()
});
require(['jquery-2.1.0.min.js','../../src/Base64.js','../../src/Twitterlist1.js'], function( $, Base64, TwitterList){
	var t = new Twitterlist('vQ5O01cUF6jk7VX24ninw','zbBvjnpcP7LAaBPB9B9vjtILWjfLh7TjvNzLWygs');
	//t.init({ids:['vampaynani']});
	//t.getAllTLs({limit:10});
});
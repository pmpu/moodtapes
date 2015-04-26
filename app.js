var app = angular.module('app', ['onsen', 'mediaPlayer', 'simple-slideshow']); 
var _hash;

var _auth = true;

var SRV = "http://46.101.170.107";

ons.ready(function(){
    initHashNav(function(hash){
        _hash = hash;
        switch(hash.base){
            case "":
                nav.resetToPage("main.html", {animation: "fade"});
                break;
            case "mood":
                nav.resetToPage("mood.html", {animation: "fade"});
                break;
            case "signin":
                nav.resetToPage("signin.html", {animation: "fade"});
                break;
            case "signup":
                nav.resetToPage("signup.html", {animation: "fade"});
                break;
            case "create":
                nav.resetToPage("create.html", {animation: "fade"});
                break;
            default:
                
        }
    });
    
    if($.cookie("session") != undefined){
        $.post(SRV+"/check_session", {session: $.cookie("session")}, function(resp){
            resp = JSON.parse(resp);
            _auth = !resp.error;
            console.log("session checked: "+(_auth?"valid":"invalid"));
            updateAuth();
        });
        
        
        
    }
    //nav.resetToPage("mood.html");
});


function updateAuth(){
    if(_auth){
        $(".auth_require").hide();
    }
}


var preloadPictures = function(pictures, callback) {
    var i,
        j,
        loaded = 0;

    for (i = 0, j = pictures.length; i < j; i++) {
        (function (img, src) {
            img.onload = function () {                               
                if (++loaded == pictures.length && callback) {
                    callback();
                }
            };

            // Use the following callback methods to debug
            // in case of an unexpected behavior.
            img.onerror = function () {};
            img.onabort = function () {};

            img.src = src;
        } (new Image(), SRV+pictures[i].file));
    }
};

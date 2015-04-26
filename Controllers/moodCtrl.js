app.controller('moodCtrl', function($scope, $element, $timeout){
    $scope.playlist = [];
    
    $scope.audioPlaylist = [];
    
     var INTERVAL = 8000,
        slides = [];

    function setCurrentSlideIndex(index) {
        $scope.currentIndex = index;
    }

    function isCurrentSlideIndex(index) {
        return $scope.currentIndex === index;
    }

    function nextSlide() {
        $scope.currentIndex = ($scope.currentIndex < $scope.slides.length - 1) ? ++$scope.currentIndex : 0;
        $timeout(nextSlide, INTERVAL);
        $el = $element.find(".player_image");
    }

    function loadSlides() {
        $timeout(nextSlide, INTERVAL);
    }
    
    $scope.slides = slides;
    $scope.currentIndex = 0;
    $scope.setCurrentSlideIndex = setCurrentSlideIndex;
    $scope.isCurrentSlideIndex = isCurrentSlideIndex;

    
    $element.find(".player_image").css("opacity", 0);
    
    $.getJSON("http://46.101.170.107/mood/"+_hash.parameters.id, function(data){
        $scope.mood = data;
        console.log(data);
        
        var music = data.music;
        $scope.playlist = data.music;
        
        $scope.slides = data.images;
        
        preloadPictures(data.images, function(){
            $element.find(".player_image").css("opacity", 1);
        });
        loadSlides();
        
        if(data.color_bg != ""){
            $(".mpage").css("background-color", data.color_bg);
        }
        
        for(var k in data.music){
            var m = data.music[k];
            console.log(m);
            $scope.audioPlaylist.push({
              title: m.title,
              artist: m.artist,
              src: 'http://46.101.170.107'+m.file,
              type: 'audio/mp3'
            });    
        }
        
        $scope.$apply();
        
    });
});
    


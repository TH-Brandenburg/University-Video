require.config({
    baseUrl: MEDIA_URL + "/assets/js",
    paths : {
        jquery : "../vendor/jquery/dist/jquery.min"
    },
    shim: {
      'jquery-deparam': {
        deps: ['jquery'],
        exports: 'jquery-deparam'
      }
    }
});

var html5Player;

require(
    [
        "jquery",
        "jquery-deparam",
        "video_player"
    ], function( $ , deparam, VideoPlayer ) {
        // $$ = $.noConflict();

        $(".televideoplayer").each(function() {
            html5Player = new VideoPlayer( $(this) );
        });
    }
);

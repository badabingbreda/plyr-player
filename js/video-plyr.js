/* create audio players and video players
	variable so we can control them after creation and from within other functions */
var plyr_audio = false , plyr_video = false;

(function( $ ) {

	const controls = [ 'play-large' , 'rewind' , 'play' , 'fast-forward' , 'progress' , 'current-time' , 'duration' , 'mute' , 'volume' , 'fullscreen' , 'settings' ];

	const tooltips = { controls: true , seek: true };

	$(document).ready( function() {

		plyr_audio = Array.from( $( '.audio-player' ) ).map( p => new Plyr( p, { settings: ['loop'] , controls : controls , seekTime : 15 , iconUrl : plyrconfig.url + 'js/custom-plyr-controls.svg' , tooltips : tooltips } ) );

		plyr_video = Array.from( $('.platform-player, .mp4-player') ).map(p => new Plyr( p , { controls : controls , seekTime : 15 , iconUrl : plyrconfig.url + 'js/custom-plyr-controls.svg' , tooltips: tooltips , hideControls : false } ) );

	});

})(jQuery);
var tag 		   = document.createElement( 'script' );
tag.src 		   = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName( 'script' )[0];
firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );

var player;

function onYouTubeIframeAPIReady() {

	player = new YT.Player(
		'player',
		{
			events: {
				'onReady': onPlayerReady
			}
		}
	);
	
}

function onPlayerReady(event) {
	
	event.target.setPlaybackQuality( 'highres' );
	
}

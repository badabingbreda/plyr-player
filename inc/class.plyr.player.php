<?php

class plyr_player {


	public static function init() {

		add_action( 'wp_enqueue_scripts' , __CLASS__ . '::enqueue_scripts' );

        add_filter( 'script_loader_tag', __CLASS__ . '::add_crossorigin_attribute', 10, 2 );

        add_shortcode( 'plyrplayer' , __CLASS__ . '::media_shortcode_handler' );

        //add_action( 'init' , __CLASS__ . '::add_cors_http_header' );
	}

    public static function add_cors_http_header(){
        header("Access-Control-Allow-Origin: *");
    }


	public static function enqueue_scripts() {

		wp_enqueue_script( 'plyr', PLYRPLAYER_URL . 'js/plyr/plyr.min.js', null, PLYRPLAYER_VERSION, false );
        wp_enqueue_script( 'plyr-init', PLYRPLAYER_URL . 'js/video-plyr.js', null , PLYRPLAYER_VERSION, true );
		wp_enqueue_style( 'plyr', PLYRPLAYER_URL . 'js/plyr/plyr.css', null , PLYRPLAYER_VERSION,  'all' );

        wp_localize_script( 'plyr-init', 'plyrconfig', array( 'url' => PLYRPLAYER_URL ) );

	}

    public static function add_crossorigin_attribute( $html, $handle ) {
        if ( 'plyr' === $handle || 'plyr-init' === $handle ) {
            return str_replace( "></script>", " crossorigin='anonymous'></script>", $html );
        }
        return $html;
    }

    /**
     * Add a shortcode that can get both audio_link (using ssp )
     *     and a lazyvideo ( using custom lazyvideo player )
     */
    public static function media_shortcode_handler( $atts ) {


        // create a buffer variable for the return
        $return_buffer = '';

        // generate a unique ID
        $uid =uniqid();


        $atts = shortcode_atts(
                    array(
                        'video_link' => '', // false when not set
                        'audio_link' => '', // false when not set
                        'duration' => '',
                        'novideo' => null,
                        'noaudio' => null,

                    ), $atts, 'plyrplayer' );

            // test if we have an audio_link
            if ( $atts[ 'audio_link' ] && !$atts[ 'noaudio' ] ) {

                $return_buffer .= self::audio_template( $atts['audio_link'] , $atts[ 'duration' ] );
            }

            // test if we have a video_link
            if ( $atts[ 'video_link' ] && !$atts[ 'novideo' ] ) {

                if ( $video = self::match_platform( $atts['video_link'] ) ) {

                    $return_buffer .= self::video_template( $video );

                } else {

                    $return_buffer .= self::mp4_template( '' , $atts[ 'video_link' ] );

                }

            }


            return $return_buffer;

    }

    /**
     * Add videoplayer for youtube or vimeo platform
     * @param  [type] $video [description]
     * @return [type]        [description]
     */
    public static function video_template( $video ) {

        return '<div data-plyr-provider="' . $video[ 'platform' ] . '" data-plyr-embed-id="' . $video[ 'id' ] . '" class="platform-player"></div>';

    }

    /**
     * Add videoplayer for hosted mp4 player
     * @param  [type] $poster [description]
     * @param  [type] $video  [description]
     * @return [type]         [description]
     */
    public static function mp4_template ( $poster , $video ) {

        return '<div class="plyrplayer"><video poster="' . $poster . '" class="mp4-player"><source src="'.$video.'" type="video/mp4" /></video></div>';

    }

    /**
     * Add audio player
     * @param  [type] $audio    [description]
     * @param  [type] $duration [description]
     * @return [type]           [description]
     */
    public static function audio_template( $audio , $duration ) {

        return '<div class="plyrplayer audio"><audio crossorigin="anonymous" playsinline class="audio-player" data-plyr-config=\'{ '. ( $duration ? '"duration": ' . $duration : '' ) .' }\'><source src="' . $audio. '" type="audio/mp3"></audio></div>';

    }

    public static function match_platform( $url ) {

        if ( $video = self::regex_youtube( $url ) ) return $video;
        if ( $video = self::regex_vimeo( $url ) ) return $video;

        return false;
    }

    public static function regex_youtube( $url ) {

    // regex to find the ID from browser url or shared url
    $re = '/^https:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9-_]{11})&?|^https:\/\/youtu.be\/([a-zA-Z0-9-_]{11})&?/';

    preg_match($re, $url , $matches);

    if ( sizeof ($matches ) > 0 ) {
        // return the ID
        return array(
            'platform' => 'youtube',
            'id' => $matches[1],
            );
    } else {
        return false;
    }

    }

    public static function regex_vimeo( $url ) {

        $re = '/^https:\/\/vimeo.com\/([0-9]{3,})/';

        preg_match($re, $url , $matches);

        if ( sizeof ($matches ) > 0 ) {
            // return the ID
        return array(
            'platform' => 'vimeo',
            'id' => $matches[1],
            );
        } else {
            return false;
        }

    }


}


plyr_player::init();

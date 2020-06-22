# Plyr Player

The plyr player is a plugin for WordPress that allows you to add a YouTube-video, Vimeo-video mp4 and external (or local) audio-file with a plyr interface and play controls.

Add player via shortcode:
[plyrplayer audio_link="" duration=""]
[plyrplayer video_link=""]

### Video

You can add the full URL in the video_link attribute, plyrplayer will automatically get the right video_ID to play it.
[plyrplayer video_link="https://www.youtube.com/watch?v=6TkFojsmdpw"]
[plyrplayer video_link="https://vimeo.com/1084537"]

### Audio
[plyrplayer audio_link="https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3" duration="183"]

Please make sure that if you host video or audio files on S3 that they can be shared cross origin.

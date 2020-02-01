<?php
###################### AVRecorder 1.1 Configuration file# ####################
######################## MANDATORY FIELDS #########################
//connectionstring:String
//affects: recorder, player
//description: the rtmp connection string to the avchat2 application on your Flash Media Server server
//values: 'rtmp://localhost/videorecorder/_definst_', 'rtmp://myfmsserver.com/videorecorder/_definst_', etc...
$config['connectionstring']='rtmp://red5.istevision.org/videorecorder/_definst_';


######################## RECORDER FIELDS #########################
//qualityurl: String
//affects: recorder
//desc: path to the .xml file describing video and audio quality to use for recording
$config['qualityurl']='audio_video_quality_profiles/320x240x15x90.xml';

//maxRecordingTime: Number
//affects: recorder
//desc: the maximum recording time in secdonds
//values: any number greater than 0;
$config['maxRecordingTime']=120;

//userId: String
//affects: recorder
//desc: the id of the user logged into the website, not mandatory, this var is passed back to the save_video_to_db.php file via GET when the [SAVE] button in the recorder is pressed
//this variable can also be passed via flash vars like this: videorecorder.swf?userId=XXX, but the value in this file, if not empty, takes precedence
//values: strings
$config['userId']='';

//incomingBuffer: Number
//affects: player, recorder when previewing recorded video
//desc: The size of the buffer for incoming data from the server, in seconds, does not affect the recording process, only the playback process (in both the recorder and player). Before data is played it is buffered in this buffer.
//values: 1,2,etc...
$config['incomingBuffer']=1;

//outgoingBuffer: Number
//affects: recorder
//desc: Specifies how long the buffer for the outgoing data can grow before Flash Player starts dropping frames. On a high-speed connection, buffer time shouldn't be a concern; data is sent almost as quickly as Flash Player can buffer it. On a slow connection, however, there might be a significant difference between how fast Flash Player buffers the data and how fast it can be sent to the client. Only affects the recording process of the recorder!
//values: 30,60,etc...
$config['outgoingBuffer']=60;

//streamName: String
//affects: player
//desc: the name fo the .flv file on the FMS/Red5 server for the player to PLAY, including the .flv extension. This does not affect the recorder as the recorder always generates a new file name!
//values:
$config['streamName']='Diablo3-CinematicTrailer_US.flv';

//autoPlay: String
//affects: player
//desc: weather the audio stream should play automatically or  wait for the user to press the PLAY button
//values: false, true
$config['autoPlay']='false';

######################### OPTIONAL FIELDS (GENERAL) ###############

##################### DO NOT EDIT BELOW ############################
foreach ($config as $key => $value){
	echo '&'.$key.'='.$value;
}
?>
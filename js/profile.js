console.log("profile.js LOADED");
//////////////////////////////////////////////////WINDOW-INTERESTS/////////////////////
$('#interest-display').live('click',function()	{

		$("#window-interests").dialog({
			width: 550, 
			height: 500, 
			modal: true,
			title:'interests'});
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////FILE UPLOAD/////////////////////
var id = '';

	function fileSelected() {
        var file = document.getElementById('fileToUpload2').files[0];
        if (file) {
          var fileSize = 0;
          if (file.size > 1024 * 1024)
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

          document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
          document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
          document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
        }
      }
	
      function uploadFile2() {
		id =$("#user-id").val();
        var fd = new FormData();
        fd.append("fileToUpload2", document.getElementById('fileToUpload2').files[0]);
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        xhr.open("POST", "actions.php?pullfile="+id);
        xhr.send(fd);
      }

      function uploadProgress(evt) {
        if (evt.lengthComputable) {
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
          document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
        }
        else {
          document.getElementById('progressNumber').innerHTML = 'unable to compute';
        }
      }
      

      function uploadComplete(evt) {
	//This refreshes image
 	//var profile_pic = document.getElementById('profile-image');
    	//profile_pic.src += "?rand2"+Math.random();
	location.reload();
      }

      function uploadFailed(evt) {
        alert("There was an error attempting to upload the file.");
      }

      function uploadCanceled(evt) {
        alert("The upload has been canceled by the user or the browser dropped the connection.");
      }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

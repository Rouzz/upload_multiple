$(document).ready(function() {
    var nbFiles;
    $("#filesToUpload").change(function() {
        var inputFiles = document.getElementById('filesToUpload');
        nbFiles = inputFiles.files.length;
        maxfilesize = "1024000";
        
        //calling the function for every files
        for (var i=0; i < nbFiles; i++)
        {
            upload_file(i, inputFiles.files[i]);
        }

    });
    
    function upload_file(j, file){
        var xhr = new XMLHttpRequest();
        
        //add file name and loading bar
        $("#loading").append("<div id='"+j+"'><span>"+file.name+"</span> <progress id='progress_"+j+"' max='1' value='0'></progress></div>");
        
        xhr.open('POST', 'upload_ajax_one.php');
        
        xhr.upload.onprogress = function(e) {
            $("#progress_"+j).attr('value', e.loaded);
            $("#progress_"+j).attr('max', e.total);
            if(e.total > maxfilesize){
                xhr.abort();
                $("#progress_"+j).attr('value', 0); //the bar is set to 0 because HTML5 don't have an error visual effect (like turning it red)
                $("div #"+j).append("<span> The uploaded filesize exceeds the limit : "+maxfilesize+"</span>");
            }
        };
        
        //php file is done loading
        xhr.onload = function() {
            if(xhr.responseText != "") //if error in upload
            {
                $("#progress_"+j).attr('value', 0);
                $("div #"+j).append("<span> "+xhr.responseText+" </span>");
            }
            else
            {
                $("div #"+j).append("<span> Upload successful</span>");
            }
        };
        
        var form = new FormData();
        form.append('filesToUpload', file);
        form.append('count', j);
        form.append('MAX_FILE_SIZE', maxfilesize); // maximum filesize : 1M

        xhr.send(form);
    }
});
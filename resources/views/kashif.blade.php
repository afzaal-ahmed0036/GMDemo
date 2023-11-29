
<!doctype html>
<html>
<head>
<title>How to Display existing files on Server in Dropzone - PHP</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="style.css" rel="stylesheet" type="text/css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://makitweb.com/demos/resources/dropzone/dist/min/dropzone.min.css" rel="stylesheet" type="text/css">
<script src="https://makitweb.com/demos/resources/dropzone/dist/min/dropzone.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
<div class='content'>
<form action="upload.php" class="dropzone">
</form>
</div>
</div>

<script type='text/javascript'>

        Dropzone.autoDiscover = false;
        $(".dropzone").dropzone({
            
            init: function() {   
                myDropzone = this;
                
                $.ajax({
                    url: '{{URL("/kupload")}}',
                    type: 'get',
                    data: {request: 2},
                    dataType: 'json',
                    success: function(response){
                        
                        $.each(response, function(key,value) {
                            var mockFile = { name: value.name, size: value.size };

                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, value.path);
                            myDropzone.emit("complete", mockFile);
                            
                            // Download link
                            var a = document.createElement('a');
                            a.setAttribute('href',"{{URL('/')}}/" + value.path);
                            a.innerHTML = "<br>download";
                            mockFile.previewTemplate.appendChild(a);
        
                        });

                    }
                });
                
            }
        });
        
        </script>
        <script type="text/javascript">
            Dropzone.options.dropzone = {
                maxFilesize: 5,
                maxFiles: 5,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                removedfile: function(file) {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: 'http://localhost:1337/extensive_books/public/AttachmentDelete',
                        data: {
                            filename: name
                        },
                        success: function(data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function(file, response) {
                    console.log(response);
                },
                error: function(file, response) {
                    return false;
                }
            };
        </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>


<!-- enctype="multipart/form-data" -->
<form action="{{URL('/base2')}}" method="post"> {{csrf_field()}} 
	
<input type="text" name="signed">

 <input type="submit" name="Submit" value="Submit" />

	</form>
     
 



</body>
</html>
<html>
<head>
  <title>Test Page</title>
  <script src="https://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript">
  $(function()
  {
    $('#abc').change( function()
    {
      
      alert($(this).val());
       var fileSelect = $(this).val();
    $('#xyz').val(fileSelect);
        console.log(fileSelect);

      
    });
  });



  </script>
</head>

<body>

 <form action="{{URL('/AirlineSummary1')}}" method="post" enctype="multipart/form-data"> 
  {{csrf_field()}} 
<input type="file" id="abc" name="abc" />



<input type="file" id="xyz" name="xyz" />
 
<!-- <input type="text" name="abc" id="abc"> -->


<div><button type="submit" class="btn btn-success w-lg float-right">Save / Update</button>
      
</div>


</form>

</body>
</html>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  $( function() {
     $('#datepicker').datepicker({
        minDate: new Date('2013'),
        maxDate: new Date(),
        changeMonth: true,
        changeYear: true,
        onClose: function (selectedDate) {
           $.ajax({
              url: "{{URL('/Ajax_Date_Url')}}",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                  chosedate: selectedDate,
                 
              },
              cache: false,
              success: function(data){
                    $('#result').html(data);
              }
          });
        }
    });

  } );
  </script>
<input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
<p>Date: <input type="text" id="datepicker"></p>
 

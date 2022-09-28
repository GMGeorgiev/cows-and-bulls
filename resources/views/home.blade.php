<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax Post Request Example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div class="container">
        <h1>Bulls & Cows</h1>
        <form id="contactform">
            @csrf
            <div class="form-group">
                <label>Digits:</label>
                <input type="text" name="culls" class="form-control" placeholder="Enter Digits">
                <span class="text-danger" id="cullsError"></span>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-success save-data" onclick="submitForm()">Go!</button>
            </div>
        </form>
        <span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
    </div>

    <h2>Top 10 scores: </h2>
    @isset($scores)
    @foreach ($scores as $score){
        <h2>{{ $score }}</h2>
    }
    @endforeach
    @endisset

    <form hidden name="add-score-post-form" id="add-score-post-form" method="post" action="{{ url('storescore') }}">
      @csrf
       <div class="form-group">
         <label for="name">Name</label>
         <input type="text" id="scorename" name="name" class="form-control" placeholder="Your name..." required="">
       </div>
       <div class="form-group">
         <label for="score">Score</label>
         <input type="hidden" id="score" name="score" class="form-control" required="">
       </div>
       <button type="submit" class="btn btn-primary">Submit score</button>
     </form>
    <script>
        function submitForm() {
          let culls = $("input[name=culls]").val();
          var _token = $("input[name='_token']").val();

          $.ajax({
            url: "{{ route('culls') }}",
            type:"POST",
            async: false,
            data:{
                culls:culls,
                _token:_token
            },
            success:function(response) {
              console.log(response);
              if(response) {
                $('.success').append(response.success);
                if(response.score !== undefined){
                  console.log(response.score);
                  $('input[name=score]').val(response.score);
                  $("#add-score-post-form").show();
                }
              }
            },
            error:function (response) {
              console.log(response.responseJSON.errors);
              $('#cullsError').text(response.responseJSON.errors.culls);
            }
           });
        }
    </script>
</body>
</html>
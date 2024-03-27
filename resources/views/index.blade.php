@extends('layouts.app')

@section('content')

   <!-- ======= Clients Section ======= -->
    @include('layouts.section')
    <!-- End Cliens Section -->   

      <!-- ======= Start Game Section ======= -->
    <section id="start-game" class="portfolio-details">
    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-7">
          <p id="enter" class="fw-bold" > Enter your name and start the game </p>          
                  
          <form class="form-inline" id="gameStart" >

            <div class="form-group mx-sm-3 mb-2" >
              <label for="" class="sr-only">Name</label>
              <input type="text" class="form-control" name="user_name" id="playerName" placeholder="Player Name">
            </div>
            <button type="submit" id="submitGame" class="btn btn-primary mb-2">Start</button>
          </form>
          <div id="errorStartForm"></div>
          <div id="submittedData"  class="" style="display: none;" >
              <!-- Display submitted data here -->
              <p id="fieldValue" class="fw-bold" >Hello</p>          
                        
              
              <!-- Display other fields similarly -->
          </div>
          <form class="form-inline" id="attempt" style="display: none;" >
                  <div class="form-group mx-sm-3 mb-2" >
                    <label for="" class="sr-only">Name</label>
                    <input type="text" class="form-control" name="number" id="guessingNumber" placeholder="Enter 4 digit number">

                    <button type="submit" id="submitAttempt" class="btn btn-success mb-1">Submit Number</button>
                  </div>
          </form> 
           <div id="errorAttemptForm"></div>           
           <div id="data-container" > </div>          
       </div>
        @include('layouts.sidebar')
      </div>
      @include('modal')
    </div>
  </section><!-- End Start Game Section -->   

  <script>
    $(document).ready(function(){
        $('#submitGame').click(function(e){
            e.preventDefault();
            $('#errorStartForm').empty();
            $('#errorAttemptForm').empty();
            var dataContainer = $('#data-container');
            var playerName = $('#playerName').val();
          
            // Get other field values similarly

            // Send AJAX POST request
            $.ajax({
                type: "POST",
                url: "{{ route('game.start') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                     user_name: playerName,

                    // Send other fields similarly
                },
                success: function(response){
                    console.log(response);
                     // Handle success response
                    $('#enter').hide();
                    $('#gameStart').hide();
                    
                    dataContainer.empty();
                   
                    playerName =   playerName  + ' make your first attempt to guess the number'

                    $('#fieldValue').text(playerName);                 
                    $('#submittedData').show();
                    $('#attempt').show();
                    $('#gameStart')[0].reset();
                   
                },
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger">';
                     
                        errorHtml += '<p>' + errors['user_name'] + '</p>'; 

                        errorHtml += '</div>';

                        // Append error HTML to a container element in your page
                        $('#errorAttemptForm').html(errorHtml);
                    } else {
                        // Handle other types of errors
                    }
                }
            });
        });
    });
    $(document).ready(function(){
        $('#submitAttempt').click(function(e){
            e.preventDefault();
            $('#errorAttemptForm').empty();

            var guessingNumber = $('#guessingNumber').val();
            $('#guessingNumber').val('')
            // Get other field values similarly

            // Send AJAX POST request
            $.ajax({
                type: "POST",
                url: "{{ route('game.guess') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                     number: guessingNumber,

                    // Send other fields similarly
                },
                success: function(response){
                    console.log(response);
                    $('#guessingNumber').val('')
                    $('#attempt')[0].reset();                  
                   
                   
                },
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger">';
                    
                        errorHtml += '<p id="element" >' + errors['number'] + '</p>'; // Assuming error messages are strings                     

                        errorHtml += '</div>';

                        // Append error HTML to a container element in your page
                        $('#errorAttemptForm').html(errorHtml);
                    } else {
                        // Handle other types of errors
                    }
                }
            });
        });
    });
   
    $(document).ready(function(){
        $('#submitAttempt').click(function(e){           
           
            $.ajax({
                url: "/attempts",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                console.log(response);           
                    // Handle the response here
                    var dataContainer = $('#data-container');
                    var fieldValue    = $('#fieldValue');
                    if( response.data.bulls == 4 ){                      
                        dataContainer.empty(); // Clear previous data if any
                        fieldValue.empty();
                        $('#attempt').hide();                   
                        $('#enter').show();
                        $('#gameStart').show();
                        dataContainer.append('<p>'+ 'You guessed  right number ' + ' ' + response.data.number_to_guess +  '</p>'); // Assuming name is a field in your data
                    } else {
                         if(response.data.error == 0){
                            dataContainer.append('<p>' + '' +'You guessed ' + ' ' + response.data.cows + ' cows and ' + ' ' + response.data.bulls + ' ' + ' bulls' + '</p>'); // Assuming name is a field in your data
                   
                         } else {
                            dataContainer.append('<p>' + '' + 'Error' + '' + '</p>'); // Assuming name is a field in your data
                         }                      
                   }              
                
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle errors here
                }
                
            });
        });
    });
    $(document).ready(function() {
            $('#fetch-games').click(function(e) {
                e.preventDefault(); // Prevent the default action of the anchor tag
                
                $.ajax({
                    url: "{{ route('games.ranking') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#games-list').empty(); // Clear previous results
                        
                        if(response.length > 0) {
                            $.each(response, function(index, game) {
                                $('#games-list').append('<li>' + game.user_name + ' finished in ' + '' + game.time_taken + '</li>');
                            });
                        } else {
                            $('#games-list').append('<li>No games found</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
</script>
@endsection

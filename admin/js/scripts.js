$(document).ready(function () {

    // Makes the Google chart responsive
    $(window).resize(function () {
        drawChart();
    });
    
    // EDITOR CKEDITOR
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        });
    
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });

        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }

    });
    
 var div_box = "<div id='load-screen'><div id='loading'></div></div>";

 $("body").prepend(div_box);

 $('#load-screen').fadeOut(600, function(){ // For load screen GIF
    $(this).remove();
 });
    
});

 function loadUsersOnline() { // AJAX for users online on administrator page
  
     $.get("functions.php?onlineusers=result", function(data) {
        $(".usersonline").text(data);
    });

    }

setInterval(function() {
    loadUsersOnline();
},500);
$(document).ready(function() {
  // Retrieve and display comments when the page loads
  getComments();

  // Handle form submission
  $('#comment-form').submit(function(e) {
    e.preventDefault();

    // Get form data
    var name = $('input[name="name"]').val();
    var comment = $('textarea[name="comment"]').val();

    // Submit comment via AJAX
    $.ajax({
      type: 'POST',
      url: 'post_comment.php',
      data: { name: name, comment: comment },
      success: function(response) {
        alert(response); // Display the response message (success or error)
        $('#comment-form')[0].reset(); // Reset the form fields
        getComments(); // Retrieve and display updated comments
      }
    });
  });

  // Retrieve and display comments from the server
  function getComments() {
    $.ajax({
      type: 'GET',
      url: 'get_comments.php',
      success: function(response) {
        $('#comments-container').html(response);
      }
    });
  }
});


//nav
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
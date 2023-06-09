// Using JavaScript to validate the form
document.getElementById("contact-form").addEventListener("submit", function(event) {
  event.preventDefault();
  var name = document.getElementsByName("name")[0].value;
  var email = document.getElementsByName("email")[0].value;
  var message = document.getElementsByName("message")[0].value;

  if (name === "" || email === "" || message === "") {
    alert("Please fill in all fields.");
    return;
  }

  // If all fields are filled, submit the form
  this.submit();
});

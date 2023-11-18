document.addEventListener('DOMContentLoaded', (event) => {
  const form = document.querySelector('form');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Client-side Validation
    if (!isFormValid(this)) {
      alert('Please fill all the required fields correctly.');
      return;
    }

    // Prepare form data for AJAX
    const formData = new FormData(this);

    // AJAX Request
    fetch('submit-contact.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.text();
      })
      .then(data => {
        // Handle server response here
        alert('Message sent successfully!');
        form.reset(); // Reset the form after successful submission
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('There was a problem with your submission: ' + error.message);
      });
  });

  function isFormValid(form) {
    // Example validation logic here
    // Check if all required fields are filled and email is in correct format
    const name = form.querySelector('[name="name"]').value;
    const email = form.querySelector('[name="email"]').value;
    const subject = form.querySelector('[name="subject"]').value;
    const message = form.querySelector('[name="message"]').value;

    return name && email && subject && message && validateEmail(email);
  }

  function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(String(email).toLowerCase());
  }
});

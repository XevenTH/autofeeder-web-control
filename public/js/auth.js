document.getElementById('recoveryForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the default way
  
    const email = document.getElementById('email').value;
  
    // Send the form data using fetch API
    fetch(recoveryRoute, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('emailSpan').textContent = email;
            document.getElementById('emailSentAlert').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
  });
  
  
  document.getElementById('passreset').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the default way
  
    const password = document.getElementById('password').value;
  
    // Send the form data using fetch API
    fetch(recoveryRoute, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('passwordChangedAlert').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
  });
  
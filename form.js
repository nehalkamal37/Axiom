
              function sendEmail(e) {
                e.preventDefault(); // stop normal form submit
              
                // collect values
                const params = {
                  from_name:   document.getElementById('name').value,
                  from_email:  document.getElementById('email').value,
                  phone:       document.getElementById('phone').value,
                  message:     document.getElementById('message').value,
                };
              
                emailjs.send(
                  'YOUR_SERVICE_ID',   // ← replace with your Service ID
                  'YOUR_TEMPLATE_ID',  // ← replace with your Template ID
                  params
                )
                .then(() => {
                  // on success, redirect to thank-you or news page
                  window.location.href = 'news.html';
                }, (err) => {
                  console.error('EmailJS error:', err);
                  alert('Oops, something went wrong. Please try again.');
                });
              
                return false; // prevent any further default
              }
            
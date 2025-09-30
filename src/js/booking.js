document.addEventListener('DOMContentLoaded', function() {
  const bookingForm = document.getElementById('bookingForm');
  
  if (bookingForm) {
    bookingForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Create FormData object from form
      const formData = new FormData(bookingForm);
      
      // Convert FormData to an object
      const bookingData = {};
      formData.forEach((value, key) => {
        bookingData[key] = value;
      });
      
      // Send data to PHP backend
      fetch('/pwebKuliner/src/php/process_booking.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(bookingData)
      })
      .then(response => response.json())
      .then(data => {
        const messageElement = document.getElementById('formMessage');
        
        if (data.success) {
          messageElement.textContent = "Booking berhasil! Terima kasih.";
          messageElement.className = "form-message success";
          bookingForm.reset(); // Clear the form
        } else {
          messageElement.textContent = data.message || "Terjadi kesalahan. Silakan coba lagi.";
          messageElement.className = "form-message error";
        }
      })
      .catch(error => {
        console.error('Error:', error);
        document.getElementById('formMessage').textContent = "Koneksi gagal. Silakan coba lagi.";
        document.getElementById('formMessage').className = "form-message error";
      });
    });
  }
});
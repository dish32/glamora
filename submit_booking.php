<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'glamorasalon_db';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $service = $_POST['service'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $discussionDate = $_POST['discussionDate'] ?? null;
    $weddingDate = $_POST['weddingDate'] ?? null;

    $query = "INSERT INTO bookings (name, email, phone, service, discussion_date, wedding_date, date, time)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $email, $phone, $service, $discussionDate, $weddingDate, $date, $time);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Form</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <form id="bookingForm">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone" required><br>
    <select name="service" id="service" required>
      <option value="">Select Service</option>
      <option value="Hair Cut">Hair Cut</option>
      <option value="Bridal Dressing">Bridal Dressing</option>
    </select><br>

    <div id="bridalFields" style="display:none;">
      <label>Discussion Date:</label>
      <input type="date" name="discussionDate"><br>
      <label>Wedding Date:</label>
      <input type="date" name="weddingDate"><br>
    </div>

    <input type="date" name="date" required><br>
    <input type="time" name="time" required><br>

    <button type="submit">Book Appointment</button>
  </form>

  <p id="pricePreview"></p>

  <script>
    const bridalFields = document.getElementById("bridalFields");
    const serviceSelect = document.getElementById("service");
    const pricePreview = document.getElementById("pricePreview");

    serviceSelect.addEventListener("change", function () {
      if (this.value === "Bridal Dressing") {
        bridalFields.style.display = "block";
      } else {
        bridalFields.style.display = "none";
      }
    });

    document.getElementById("bookingForm").addEventListener("submit", function(event) {
      event.preventDefault();

      const formData = new FormData(this);

      fetch("submit_booking.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Appointment Confirmed!',
            html: `
              <strong>Name:</strong> ${formData.get("name")}<br>
              <strong>Email:</strong> ${formData.get("email")}<br>
              <strong>Phone:</strong> ${formData.get("phone")}<br>
              <strong>Service:</strong> ${formData.get("service")}<br>
              ${formData.get("service") === "Bridal Dressing" ? `<strong>Discussion Date:</strong> ${formData.get("discussionDate")}<br><strong>Wedding Date:</strong> ${formData.get("weddingDate")}<br>` : ""}
              <strong>Date:</strong> ${formData.get("date")}<br>
              <strong>Time:</strong> ${formData.get("time")}<br><br>
              📞 For inquiries: 0912242006
            `,
            confirmButtonText: 'OK'
          });
          this.reset();
          pricePreview.textContent = '';
          bridalFields.style.display = 'none';
        } else {
          Swal.fire('Error', 'Failed to save booking. Please try again.', 'error');
        }
      })
      .catch(err => {
        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
        console.error(err);
      });
    });
  </script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salon Booking Form</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #5C4033;
      padding: 20px;
      margin: 0;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #d2b48c;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.8s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      text-align: center;
      color: #80461B;
    }
    .form-group {
      position: relative;
      margin-bottom: 20px;
    }
    label {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #d2b48c;
      padding: 0 5px;
      transition: 0.2s;
      color: #333;
      font-size: 14px;
    }
    input:focus + label,
    input:not(:placeholder-shown) + label,
    select:focus + label,
    select:not(:placeholder-shown) + label {
      top: -12px;
      font-size: 12px;
      color: #80461B;
    }
    input, select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      background: #fff;
      color: #333;
      margin-top: 10px;
      transition: border 0.3s, box-shadow 0.3s;
    }
    input:focus, select:focus {
      border-color: #a0522d;
      box-shadow: 0 0 6px #a0522d;
    }
    .submit-btn {
      background-color: #80461B;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
      width: 100%;
    }
    .submit-btn:hover {
      background-color: #663300;
    }
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #fff;
    }
    #pricePreview {
      font-weight: bold;
      color: #663300;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Book Your Appointment</h2>
  <form id="bookingForm" action="adBook.php" method="POST">
    <div class="form-group">
      <input type="text" id="name" name="name" placeholder=" " required>
      <label for="name">Full Name</label>
    </div>
    <div class="form-group">
      <input type="email" id="email" name="email" placeholder=" " required>
      <label for="email">Email Address</label>
    </div>
    <div class="form-group">
      <input type="tel" id="phone" name="phone" placeholder=" " required>
      <label for="phone">Phone Number</label>
    </div>
    <div class="form-group">
      <select id="service" name="service" required>
        <option value="" disabled selected hidden></option>
        <option value="Hair Colour">Hair Colour</option>
        <option value="Facial">Facial</option>
        <option value="Cleanup">Cleanup</option>
        <option value="Acne Treatment">Acne Treatment</option>
        <option value="Hair Extension">Hair Extension</option>
        <option value="Straightening">Straightening</option>
        <option value="Glamora Special">Glamora Special</option>
        <option value="Bridal Dressing">Bridal Dressing</option>
        <option value="Makeup">Makeup</option>
        <option value="Nail Art">Nail Art</option>
      </select>
      <label for="service">Choose Service</label>
      <div id="pricePreview"></div>
    </div>
    <div id="bridalFields" style="display:none;">
      <div class="form-group">
        <input type="date" id="discussionDate" name="discussionDate">
        <label for="discussionDate">Discussion Date</label>
      </div>
      <div class="form-group">
        <input type="date" id="weddingDate" name="weddingDate">
        <label for="weddingDate">Wedding Date</label>
      </div>
    </div>
    <div class="form-group">
      <input type="date" id="date" name="date" required>
      <label for="date">Appointment Date</label>
    </div>
    <div class="form-group">
      <input type="time" id="time" name="time" required>
      <label for="time">Appointment Time</label>
    </div>
    <button type="submit" class="submit-btn">Book Appointment</button>
  </form>
</div>
<div class="footer">
  <p>Thank you for booking with us! We look forward to serving you.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const servicePrices = {
    "Hair Colour": 10000,
    "Facial": 2500,
    "Cleanup": 5000,
    "Acne Treatment": 9000,
    "Hair Extension": 54000,
    "Straightening": 14000,
    "Glamora Special": 58000,
    "Bridal Dressing": 500000,
    "Makeup": 25000,
    "Nail Art": 5000
  };

  const serviceSelect = document.getElementById('service');
  const pricePreview = document.getElementById('pricePreview');
  const bridalFields = document.getElementById('bridalFields');

  serviceSelect.addEventListener('change', function () {
    const selected = this.value;
    pricePreview.textContent = selected ? `Price: LKR ${servicePrices[selected].toLocaleString()}` : '';
    const showBridal = selected === "Bridal Dressing";
    bridalFields.style.display = showBridal ? 'block' : 'none';
    document.getElementById('discussionDate').required = showBridal;
    document.getElementById('weddingDate').required = showBridal;
  });

  document.getElementById('bookingForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const bookingDetails = {
      name: document.getElementById('name').value,
      email: document.getElementById('email').value,
      phone: document.getElementById('phone').value,
      service: document.getElementById('service').value,
      discussionDate: document.getElementById('discussionDate').value,
      weddingDate: document.getElementById('weddingDate').value,
      date: document.getElementById('date').value,
      time: document.getElementById('time').value
    };

    let message = `<strong>Name:</strong> ${bookingDetails.name}<br>` +
                  `<strong>Email:</strong> ${bookingDetails.email}<br>` +
                  `<strong>Phone:</strong> ${bookingDetails.phone}<br>` +
                  `<strong>Service:</strong> ${bookingDetails.service}<br>`;

    if (bookingDetails.service === "Bridal Dressing") {
      message += `<strong>Discussion Date:</strong> ${bookingDetails.discussionDate}<br>` +
                 `<strong>Wedding Date:</strong> ${bookingDetails.weddingDate}<br>`;
    }

    message += `<strong>Date:</strong> ${bookingDetails.date}<br>` +
               `<strong>Time:</strong> ${bookingDetails.time}<br><br>` +
               `📞 For inquiries: 0912242006`;

    Swal.fire({
      icon: 'success',
      title: 'Appointment Confirmed!',
      html: message,
      confirmButtonText: 'OK'
    }).then(() => {
      e.target.submit();
    });
  });
</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            background-color: white;
            padding: 30px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .section {
            margin-top: 20px;
        }
        .section label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input[type="text"], input[type="tel"], input[type="number"], input[type="month"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #7b4adb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #6539c3;
        }
    </style>
    <script>
        function togglePaymentFields() {
            var method = document.querySelector('input[name="payment_method"]:checked').value;
            document.getElementById("cardFields").style.display = (method === "card") ? "block" : "none";
            document.getElementById("cashFields").style.display = (method === "cash") ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Select Payment Method</h2>
        <form action="process_payment.php" method="POST">
            <div>
                <input type="radio" name="payment_method" value="card" onclick="togglePaymentFields()" required> Card Payment<br>
                <input type="radio" name="payment_method" value="cash" onclick="togglePaymentFields()"> Cash on Delivery
            </div>

            <div id="cardFields" class="section" style="display:none;">
                <label>Card Number</label>
                <input type="text" name="card_number" maxlength="16">

                <label>Card Holder's Name</label>
                <input type="text" name="card_holder">

                <label>CVC</label>
                <input type="number" name="cvc" maxlength="4">

                <label>Expiry Date</label>
                <input type="month" name="expiry">
            </div>

            <div id="cashFields" class="section" style="display:none;">
                <label>Name</label>
                <input type="text" name="cash_name">

                <label>Address</label>
                <input type="text" name="address">

                <label>Contact Number</label>
                <input type="tel" name="contact" maxlength="10">

                <label>Landmark</label>
                <input type="text" name="landmark">
            </div>

            <button type="submit" class="btn">Make Payment</button>
        </form>
    </div>
</body>
</html>
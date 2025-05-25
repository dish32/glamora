<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            
       background: url('pay.png') no-repeat center center fixed;
        background-size: cover;
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       transition: background-color 0.4s ease;
        background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.4s ease;
        }
        
        .container {
            max-width: 500px;
            max-height: 8000px ;
            background-color: white;
            padding: 50px;
            margin: 80px auto;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            animation: fadeIn 1s ease-in-out;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6b3e26;
        }
        .section {
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
        }
        label {
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
            transition: box-shadow 0.3s ease;
        }
        input:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(150, 75, 0, 0.5);
        }
        .btn {
            background-color: #964B00;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #C4A484;
        }
        .hidden {
            display: none;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .slide-in {
            animation: slideIn 0.5s ease forwards;
        }
        @keyframes slideIn {
            from {opacity: 0; transform: translateX(-20px);}
            to {opacity: 1; transform: translateX(0);}
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Payment Method</h2>
        <form id="paymentForm">
            <div>
                <br><br>
                <input type="radio" name="payment_method" value="card" onclick="togglePaymentFields()" required> Card Payment<br>
                <input type="radio" name="payment_method" value="cash" onclick="togglePaymentFields()"> Cash on Delivery
                <br><br><br>
                <br>
            </div>

            <div id="cardFields" class="section hidden">
                <label>Card Number</label>
                <input type="text" name="card_number" maxlength="19" oninput="formatCardNumber(this)">

                <label>Card Holder's Name</label>
                <input type="text" name="card_holder">

                <label>CVC</label>
                <input type="number" name="cvc" maxlength="4">

                <label>Expiry Date</label>
                <input type="month" name="expiry">
            </div>

            <div id="cashFields" class="section hidden">
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

    <script>
        function togglePaymentFields() {
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            const cardFields = document.getElementById("cardFields");
            const cashFields = document.getElementById("cashFields");

            cardFields.classList.add("hidden");
            cashFields.classList.add("hidden");

            if (method === "card") {
                cardFields.classList.remove("hidden");
                cardFields.classList.add("slide-in");
            } else if (method === "cash") {
                cashFields.classList.remove("hidden");
                cashFields.classList.add("slide-in");
            }
        }

        function formatCardNumber(input) {
            let value = input.value.replace(/\D/g, "");
            value = value.match(/.{1,4}/g);
            input.value = value ? value.join(" ") : "";
        }

        // Alert on form submission
        document.getElementById("paymentForm").addEventListener("submit", function (e) {
            e.preventDefault(); // prevent form from submitting
            Swal.fire({
                icon: 'success',
                title: 'Payment Processed!',
                text: 'Thank you for your payment.',
                confirmButtonColor: '#964B00'
            }).then(() => {
                this.submit(); // submit after confirmation
            });
        });
    </script>
</body>
</html>

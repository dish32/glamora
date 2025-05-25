const express = require('express');
const twilio = require('twilio');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.json());

// Twilio credentials (replace these with your actual Twilio account SID and Auth Token)
const accountSid = 'your_account_sid';
const authToken = 'your_auth_token';
const client = twilio(accountSid, authToken);

let otp = ''; // Store the OTP temporarily

// Endpoint to send OTP
app.post('/send-otp', (req, res) => {
    const { phone } = req.body;
    otp = Math.floor(1000 + Math.random() * 9000).toString();

    // Send OTP using Twilio
    client.messages.create({
        body: `Your OTP is: ${otp}`,
        from: '+1234567890', // Replace with your Twilio number
        to: phone
    }).then(message => {
        res.send({ status: 'success' });
    }).catch(error => {
        res.status(500).send({ status: 'error', message: error.message });
    });
});

// Endpoint to verify OTP
app.post('/verify-otp', (req, res) => {
    const { otp: enteredOtp } = req.body;

    if (enteredOtp === otp) {
        res.send({ status: 'success' });
    } else {
        res.status(400).send({ status: 'error', message: 'Invalid OTP' });
    }
});

// Start the server
app.listen(3000, () => {
    console.log('Server is running on port 3000');
});

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937; /* Dark background */
            color: #d1d5db; /* Light text */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .contact-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: #2d3748; /* Card background */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .contact-container h1 {
            text-align: center;
            color: #34a853; /* Accent green */
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .contact-container h3 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #a0aec0;
            margin-top: 25px;
        }

        .contact-container p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #d1d5db;
            margin-bottom: 15px;
        }

        .contact-container form {
            margin-top: 20px;
        }

        .contact-container .form-group {
            margin-bottom: 20px;
        }

        .contact-container .form-control {
            background-color: #1a202c;
            color: #d1d5db;
            border: 1px solid #4a5568;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .contact-container .form-control:focus {
            outline: none;
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }

        .contact-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #34a853;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .contact-container button:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
        }

        .contact-container a {
            text-decoration: none;
            color: #34a853;
        }

        .contact-container a:hover {
            color: #2c9c46;
        }

        .contact-info {
            margin-top: 30px;
            text-align: center;
        }

        .contact-info p {
            font-size: 1.1rem;
        }

        .contact-info a {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>If you have any questions or need assistance, feel free to get in touch with us. We are here to help!</p>
        
        <h3>Contact Form</h3>
        <form action="contact_form_handler.php" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write your message" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>

        <div class="contact-info">
            <h3>Alternatively, you can reach us at:</h3>
            <p>Email: <a href="mailto:support@stride-sync.com">support@stride-sync.com</a></p>
            <p>Phone: +91 8217044398</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937; /* Dark background */
            color: #d1d5db; /* Light text */
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .thank-you-container {
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            background-color: #2d3748; /* Card background */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .thank-you-container h1 {
            color: #34a853; /* Accent green */
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .thank-you-container p {
            font-size: 1.2rem;
            color: #a0aec0; /* Subtle text color */
            margin-bottom: 20px;
        }

        .thank-you-container a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #34a853;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        .thank-you-container a:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
        }
    </style>
</head>
<body>

<div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Your message has been sent successfully. We'll get back to you shortly!</p>
    <a href="HOME.html">Back to Home</a>
</div>

</body>
</html>

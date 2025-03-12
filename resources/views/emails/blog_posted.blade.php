<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Blog Posted by Your Friend</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            margin-top: 0;
            font-size: 20px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #777777;
            border-radius: 0 0 8px 8px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Blog Posted by {{ $senderName }}</h1>
        </div>
        <div class="content">
            <h2>{{ $blog->title }}</h2>
            <p>{{ $blog->content }}</p>
        </div>
        <div class="footer">
            <p>Thank you for following. Stay tuned for more updates!</p>
            <p><a href="{{ url('/') }}">Visit Our Website</a></p>
        </div>
    </div>
</body>
</html>

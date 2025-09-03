<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: left;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: left;
        }
        .email-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .email-body {
            padding: 30px;
            text-align: left;
        }
        .email-footer {
            padding: 15px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
            font-size: 12px;
            color: #666;
            text-align: left;
        }
        h1, h2, h3 {
            color: #333;
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .info-box {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .warning-box {
            background-color: #fff3e0;
            border: 1px solid #ffcc02;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .success-box {
            background-color: #e8f5e8;
            border: 1px solid #4caf50;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .alert-box {
            background-color: #ffebee;
            border: 1px solid #f44336;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .detail-list {
            margin: 15px 0;
        }
        .detail-list dt {
            font-weight: bold;
            margin-top: 10px;
        }
        .detail-list dd {
            margin-left: 0;
            margin-bottom: 5px;
        }
        * {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        <div class="email-body">
            @yield('content')
        </div>
        
        <div class="email-footer">
            <p>This is an automated message from {{ config('app.name') }}.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 25px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #94a3b8;
        }
        .product-badge {
            display: inline-block;
            background-color: #ef4444;
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }
        .content {
            padding: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table th, .info-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-table th {
            width: 32%;
            background-color: #f8fafc;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table td {
            color: #1e293b;
            font-size: 15px;
            font-weight: 500;
        }
        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 15px 20px;
            border-radius: 0 6px 6px 0;
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 15px 30px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Webwiders Software Solutions</h1>
            @if(!empty($data['product_name']) || !empty($contactData['product_name']))
                <div class="product-badge">Product Demo Request: {{ $data['product_name'] ?? $contactData['product_name'] }}</div>
            @else
                <p>New Website Contact Form Submission</p>
            @endif
        </div>
        <div class="content">
            <table class="info-table">
                @if(!empty($data['product_name']) || !empty($contactData['product_name']))
                <tr style="background-color: #fef2f2;">
                    <th>Target Product</th>
                    <td style="color: #dc2626; font-weight: bold;">{{ $data['product_name'] ?? $contactData['product_name'] }}</td>
                </tr>
                @endif
                <tr>
                    <th>Full Name</th>
                    <td>{{ $data['name'] ?? $contactData['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><a href="mailto:{{ $data['email'] ?? $contactData['email'] ?? '' }}" style="color: #3b82f6; text-decoration: none;">{{ $data['email'] ?? $contactData['email'] ?? 'N/A' }}</a></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>{{ $data['number'] ?? $data['phone'] ?? $contactData['number'] ?? $contactData['phone'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Submitted At</th>
                    <td>{{ $data['submitted_at'] ?? $contactData['submitted_at'] ?? date('Y-m-d H:i:s A') }}</td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td>{{ $data['ip_address'] ?? $contactData['ip_address'] ?? 'N/A' }}</td>
                </tr>
            </table>

            <h4 style="margin-bottom: 10px; color: #1e293b;">Enquiry / Message Content:</h4>
            <div class="message-box">
                {!! nl2br(e($data['message'] ?? $contactData['message'] ?? 'No message provided.')) !!}
            </div>
        </div>
        <div class="footer">
            This email was sent automatically from the website via Webwiders Mail Engine.
        </div>
    </div>
</body>
</html>

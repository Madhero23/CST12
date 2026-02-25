<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry Received</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #235c63 0%, #2f7a85 100%);
            color: white;
            padding: 30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f4f9fa;
            padding: 30px;
            border: 1px solid #e0e0e0;
        }
        .inquiry-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #5fb1b7;
        }
        .detail-row {
            margin: 15px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #235c63;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .message-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-top: 5px;
            white-space: pre-wrap;
        }
        .button {
            display: inline-block;
            background: #2f7a85;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .button:hover {
            background: #235c63;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
            margin-top: 20px;
        }
        .badge {
            display: inline-block;
            background: #dc143c;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 New Inquiry Received <span class="badge">NEW</span></h1>
    </div>
    
    <div class="content">
        <p>A new inquiry has been submitted through the contact form.</p>
        
        <div class="inquiry-details">
            <div class="detail-row">
                <span class="label">From:</span>
                <span class="value">{{ $inquiry->name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></span>
            </div>
            
            @if($inquiry->phone)
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></span>
            </div>
            @endif
            
            @if($inquiry->company)
            <div class="detail-row">
                <span class="label">Company:</span>
                <span class="value">{{ $inquiry->company }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="label">Subject:</span>
                <span class="value"><strong>{{ $inquiry->subject }}</strong></span>
            </div>
            
            @if($inquiry->product_name)
            <div class="detail-row">
                <span class="label">Product Interest:</span>
                <span class="value">{{ $inquiry->product_name }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="label">Message:</span>
                <div class="message-box">{{ $inquiry->message }}</div>
            </div>
            
            <div class="detail-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $inquiry->created_at->format('M d, Y h:i A') }}</span>
            </div>
            
            @if($inquiry->ip_address)
            <div class="detail-row">
                <span class="label">IP Address:</span>
                <span class="value">{{ $inquiry->ip_address }}</span>
            </div>
            @endif
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $adminUrl }}" class="button">View in Admin Panel</a>
        </div>
        
        <p style="margin-top: 30px; color: #666; font-size: 14px;">
            <strong>Next Steps:</strong><br>
            • Review the inquiry details<br>
            • Respond to the customer within 24 hours<br>
            • Update the inquiry status in the admin panel
        </p>
    </div>
    
    <div class="footer">
        <p>
            <strong>RozMed Medical Equipment</strong><br>
            This is an automated notification from your inquiry management system.
        </p>
    </div>
</body>
</html>

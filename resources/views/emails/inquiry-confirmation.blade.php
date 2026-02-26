<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Inquiry</title>
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
            padding: 40px 30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            opacity: 0.9;
        }
        .content {
            background: white;
            padding: 40px 30px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .greeting {
            font-size: 18px;
            color: #235c63;
            margin-bottom: 20px;
        }
        .summary-box {
            background: #f4f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid #5fb1b7;
        }
        .summary-box h3 {
            margin: 0 0 15px 0;
            color: #235c63;
            font-size: 16px;
        }
        .summary-item {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .summary-item:last-child {
            border-bottom: none;
        }
        .summary-label {
            font-weight: 600;
            color: #666;
            display: inline-block;
            min-width: 80px;
        }
        .info-box {
            background: #fff9e6;
            border: 1px solid #ffd700;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box strong {
            color: #b8860b;
        }
        .button {
            display: inline-block;
            background: #2f7a85;
            color: white;
            padding: 14px 35px;
            text-decoration: none;
            border-radius: 6px;
            margin: 25px 0;
            font-weight: 600;
            font-size: 16px;
        }
        .button:hover {
            background: #235c63;
        }
        .contact-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .contact-info h4 {
            margin: 0 0 15px 0;
            color: #235c63;
        }
        .contact-info p {
            margin: 8px 0;
        }
        .footer {
            text-align: center;
            padding: 30px 20px;
            color: #666;
            font-size: 14px;
            background: #f4f9fa;
            border-radius: 0 0 8px 8px;
        }
        .footer p {
            margin: 5px 0;
        }
        .checkmark {
            font-size: 48px;
            color: #008236;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="checkmark">✓</div>
        <h1>Thank You for Contacting Us!</h1>
        <p>We've received your inquiry</p>
    </div>
    
    <div class="content">
        <p class="greeting">Dear {{ $inquiry->name }},</p>
        
        <p>
            Thank you for reaching out to <strong>RozMed Medical Equipment</strong>. 
            We have successfully received your inquiry and our team will review it shortly.
        </p>
        
        <div class="summary-box">
            <h3>📋 Your Inquiry Summary</h3>
            <div class="summary-item">
                <span class="summary-label">Subject:</span>
                <span>{{ $inquiry->subject }}</span>
            </div>
            @if($inquiry->product_name)
            <div class="summary-item">
                <span class="summary-label">Product:</span>
                <span>{{ $inquiry->product_name }}</span>
            </div>
            @endif
            <div class="summary-item">
                <span class="summary-label">Submitted:</span>
                <span>{{ $inquiry->created_at->format('M d, Y h:i A') }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Reference:</span>
                <span>#{{ str_pad($inquiry->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="info-box">
            <strong>⏱️ What happens next?</strong><br>
            Our team typically responds to inquiries within <strong>24 hours</strong> during business days. 
            We'll get back to you at <strong>{{ $inquiry->email }}</strong> with the information you requested.
        </div>
        
        <p>
            In the meantime, feel free to explore our website to learn more about our medical equipment 
            and services. If you have any urgent questions, please don't hesitate to contact us directly.
        </p>
        
        <div style="text-align: center;">
            <a href="{{ $contactUrl }}" class="button">Visit Our Website</a>
        </div>
        
        <div class="contact-info">
            <h4>📞 Contact Information</h4>
            <p><strong>Email:</strong> info@rozmed.com</p>
            <p><strong>Phone:</strong> +63 (123) 456-7890</p>
            <p><strong>Business Hours:</strong> Monday - Friday, 8:00 AM - 6:00 PM</p>
        </div>
        
        <p style="margin-top: 30px;">
            We appreciate your interest in RozMed Medical Equipment and look forward to serving you.
        </p>
        
        <p style="margin-top: 20px;">
            Best regards,<br>
            <strong>The RozMed Team</strong>
        </p>
    </div>
    
    <div class="footer">
        <p><strong>RozMed Medical Equipment</strong></p>
        <p>Your Trusted Partner in Medical Equipment Solutions</p>
        <p style="margin-top: 15px; font-size: 12px; color: #999;">
            This is an automated confirmation email. Please do not reply directly to this message.
        </p>
    </div>
</body>
</html>

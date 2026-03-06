<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .reservation-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #ecf0f1;
            border-left: 4px solid #3498db;
        }
        .detail-row {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }
        .detail-label {
            font-weight: bold;
            color: #2c3e50;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
        }
        .success-message {
            color: #27ae60;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Restaurant Reservation Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $reservation->surname }},</p>
            
            <div class="success-message">
                ✓ Your reservation has been successfully confirmed!
            </div>
            
            <p>Thank you for making a reservation at our restaurant. Here are your reservation details:</p>
            
            <div class="reservation-details">
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span>{{ $reservation->surname }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span>{{ $reservation->reservation_date->format('F d, Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Session:</span>
                    <span>{{ $sessionLabel }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span>{{ $reservation->reservation_time->format('h:i A') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Number of Guests:</span>
                    <span>{{ $reservation->number_of_guests }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Phone Number:</span>
                    <span>{{ $reservation->phone_number }}</span>
                </div>
                
                @if($reservation->notes)
                <div class="detail-row">
                    <span class="detail-label">Special Requests:</span>
                    <span>{{ $reservation->notes }}</span>
                </div>
                @endif
            </div>
            
            <p>If you need to modify or cancel your reservation, please contact us as soon as possible.</p>
            
            <p>We look forward to welcoming you at our restaurant!</p>
            
            <p>Best regards,<br><strong>Restaurant Management</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>

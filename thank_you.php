<?php
$business_id = $_GET['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Bharat Directory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .thank-you-card {
            background: white;
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .success-icon i {
            font-size: 50px;
            color: white;
        }
        
        .thank-you-title {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .thank-you-message {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .reference-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .reference-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .reference-number {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }
        
        .status-timeline {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .status-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        
        .status-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        
        .status-dot.completed {
            background: #28a745;
            color: white;
        }
        
        .status-dot.pending {
            background: #ffc107;
            color: white;
        }
        
        .status-dot.upcoming {
            background: #e9ecef;
            color: #999;
        }
        
        .status-text {
            font-size: 12px;
            color: #666;
        }
        
        .status-line {
            width: 50px;
            height: 3px;
            background: #e9ecef;
            align-self: center;
            margin-bottom: 25px;
        }
        
        .status-line.completed {
            background: #28a745;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        
        .action-btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .action-btn.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .action-btn.secondary {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .action-btn.secondary:hover {
            background: #e9ecef;
        }
        
        .info-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            text-align: left;
        }
        
        .info-box h4 {
            color: #667eea;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-box ul {
            list-style: none;
            color: #666;
            font-size: 14px;
        }
        
        .info-box li {
            padding: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-box li i {
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="thank-you-card">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>
    
    <h1 class="thank-you-title">Thank You! 🎉</h1>
    
    <p class="thank-you-message">
        Your business has been submitted successfully!<br>
        Our team will review your listing and approve it within 24-48 hours.
    </p>
    
    <?php if ($business_id): ?>
    <div class="reference-box">
        <div class="reference-label">Reference Number</div>
        <div class="reference-number">BD<?= str_pad($business_id, 6, '0', STR_PAD_LEFT) ?></div>
    </div>
    <?php endif; ?>
    
    <div class="status-timeline">
        <div class="status-step">
            <div class="status-dot completed">
                <i class="fas fa-check"></i>
            </div>
            <span class="status-text">Submitted</span>
        </div>
        
        <div class="status-line completed"></div>
        
        <div class="status-step">
            <div class="status-dot pending">
                <i class="fas fa-clock"></i>
            </div>
            <span class="status-text">Under Review</span>
        </div>
        
        <div class="status-line"></div>
        
        <div class="status-step">
            <div class="status-dot upcoming">
                <i class="fas fa-globe"></i>
            </div>
            <span class="status-text">Live</span>
        </div>
    </div>
    
    <div class="action-buttons">
        <a href="index.php" class="action-btn primary">
            <i class="fas fa-home"></i>
            Go to Home
        </a>
        <a href="add_business.php" class="action-btn secondary">
            <i class="fas fa-plus"></i>
            Add Another
        </a>
    </div>
    
    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> What's Next?</h4>
        <ul>
            <li><i class="fas fa-check-circle"></i> Our team will verify your business details</li>
            <li><i class="fas fa-check-circle"></i> You'll receive an email once approved</li>
            <li><i class="fas fa-check-circle"></i> Your business will appear in search results</li>
        </ul>
    </div>
</div>

</body>
</html>
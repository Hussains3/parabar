<!DOCTYPE html>
<html>
<head>
    <title>File Registration Notification</title>
</head>
<body>
    <h2>Benapole C&F Agents Association</h2>
    <p>Dear {{ $agent_name }},</p>

    <p>Your file has been successfully registered with the following details:</p>

    <ul>
        <li><strong>B/E Number:</strong> {{ $be_number }}</li>
        <li><strong>B/E Date:</strong> {{ $be_date }}</li>
        <li><strong>Importer/Exporter:</strong> {{ $ie_name }}</li>
        <li><strong>Manifest No:</strong> {{ $manifest_no }}</li>
        <li><strong>Manifest Date:</strong> {{ $manifest_date }}</li>
    </ul>

    <p>Thank you for using our services.</p>

    <p>Best regards,<br>
    Benapole C&F Agents Association</p>
</body>
</html>

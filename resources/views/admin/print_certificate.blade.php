<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Certificate</title>
    <style>
        @page {
            size: legal landscape;
            margin: 0;
        }
        body {
            margin: 40px;
            font-family: 'Times New Roman', Times, serif;
        }
        .certificate {
            width: 1680px;
            height: 1000px;
            background: url('{{ asset('certificatefront.jpg') }}') no-repeat center center;
            background-size: cover;
            position: relative;
            margin: 0 auto;
            text-align: center;
        }

        .agentname{
            position: absolute;
            top: 515px;
            left: 50%;
        }
        .aentlocation{
            position: absolute;
            top: 590px;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .agentlicensenumber{
            position: absolute;
            top: 650px;
            left: 72%;
        }
        .issuedate{
            position: absolute;
            top: 715px;
            left: 22%;
        }
        .expiredate{
            position: absolute;
            top: 715px;
            left: 50%;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px">
        <button onclick="window.print()">Print Certificate</button>
        <button onclick="window.history.back()">Go Back</button>
    </div>

    <div class="certificate" style="background: url('{{ asset('certificateback.jpg') }}')">


        <div class="content">
            <h2 class="agentname">{{ $name }}</h2>
            <h2 class="aentlocation">সি এন্ড এফ এজেণ্ট বেনাপোল</h2>
            <h2 class="agentlicensenumber">{{ $license_number }}</h2>
            <h2 class="issuedate"><strong>{{ $issue_date }}</strong></h2>
            <h2 class="expiredate"><strong>{{ $expire_date }}</strong></h2>
        </div>

    </div>
</body>
</html>

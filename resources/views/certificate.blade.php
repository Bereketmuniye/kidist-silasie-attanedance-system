<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: #f5f5f5;
        }
        
        .certificate {
            width: 100vw;
            height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .certificate-inner {
            width: 90%;
            height: 85%;
            background: white;
            border: 10px solid #d4af37;
            position: relative;
            padding: 50px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .certificate-border {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 3px solid #d4af37;
            border-radius: 5px;
            pointer-events: none;
        }
        
        .certificate-header {
            margin-bottom: 30px;
        }
        
        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Times New Roman', serif;
        }
        
        .certificate-subtitle {
            font-size: 20px;
            color: #7f8c8d;
            font-style: italic;
            margin-bottom: 40px;
        }
        
        .certificate-body {
            margin: 40px 0;
        }
        
        .certificate-text {
            font-size: 18px;
            color: #34495e;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .student-name {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin: 25px 0;
            text-decoration: underline;
            text-decoration-color: #d4af37;
            text-decoration-thickness: 3px;
            font-family: 'Times New Roman', serif;
        }
        
        .exam-title {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
            font-style: italic;
        }
        
        .certificate-score {
            font-size: 20px;
            color: #34495e;
            margin: 20px 0;
            font-weight: 500;
        }
        
        .certificate-date {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 30px;
        }
        
        .certificate-footer {
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 80px;
        }
        
        .signature-block {
            text-align: center;
        }
        
        .signature-line {
            width: 180px;
            border-top: 2px solid #34495e;
            margin-bottom: 5px;
        }
        
        .signature-title {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 500;
        }
        
        .seal {
            position: absolute;
            bottom: 40px;
            right: 80px;
            width: 70px;
            height: 70px;
            border: 4px solid #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            font-weight: bold;
            color: #2c3e50;
            font-size: 10px;
            text-align: center;
            line-height: 1.2;
        }
        
        .emblem {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .decorative-line {
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-inner">
            <div class="certificate-border"></div>
            <div class="emblem">AMS</div>
            
            <div class="certificate-header">
                <div class="certificate-title">Certificate of Achievement</div>
                <div class="certificate-subtitle">This is to certify that</div>
            </div>
            
            <div class="certificate-body">
                <div class="student-name">{{ $studentName }}</div>
                
                <div class="certificate-text">
                    has successfully completed the examination
                </div>
                
                <div class="exam-title">{{ $examTitle }}</div>
                
                <div class="decorative-line"></div>
                
                <div class="certificate-score">
                    with a score of <strong>{{ $score }}</strong>
                </div>
                
                <div class="certificate-date">
                    Awarded on {{ $completionDate }}
                </div>
            </div>
            
            <div class="certificate-footer">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-title">Director</div>
                </div>
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-title">Instructor</div>
                </div>
            </div>
            
            <div class="seal">
                OFFICIAL<br>SEAL<br>#{{ $studentId }}
            </div>
        </div>
    </div>
</body>
</html>

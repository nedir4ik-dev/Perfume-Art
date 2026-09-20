<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            border-bottom: 2px solid #0dcaf0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .original-message {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #6c757d;
            font-style: italic;
            margin: 20px 0;
        }

        .reply-box {
            background: #e7faff;
            padding: 15px;
            border-left: 4px solid #0dcaf0;
            font-weight: 500;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #0dcaf0; margin: 0;">Perfume Art</h2>
        </div>

        <p>Salam, <strong>{{ $originalContact->name }}</strong>!</p>
        <p>Bize ýazan hatyňyz üçin sag boluň. Siziň hatyňyza jogabymyz:</p>

        <div class="reply-box">
            {{ $replyMessage }}
        </div>

        <div class="original-message">
            <strong>Siziň hatyňyz:</strong><br>
            "{{ $originalContact->message }}"
        </div>

        <p>Siz bilen aragatnaşykda bolanymyza şat!</p>

        <div class="footer">
            © {{ date('Y') }} Perfume Art. Ähli hukuklar goralan.
        </div>
    </div>
</body>

</html>
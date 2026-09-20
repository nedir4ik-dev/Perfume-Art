<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #1a1a1a;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .content {
            padding: 30px;
            line-height: 1.6;
            color: #333333;
        }

        .order-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #d4af37;
        }

        .footer {
            background: #f4f4f4;
            color: #888888;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }

        .btn {
            background: #d4af37;
            color: white !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            display: inline-block;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; letter-spacing: 2px;">PERFUME-ART</h1>
            <p style="margin:5px 0 0; color: #d4af37; font-style: italic;">Exclusive Collection</p>
        </div>
        <div class="content">
            <h2>Salam, {{ $order->customer_name }}!</h2>
            <p>Siziň sargydyňyz biziň hünärmenlerimiz tarapyndan üstünlikli kabul edildi. Häzirki wagtda hünärmenlerimiz sargydyňyzy taýýarlaýarlar.</p>

            <div class="order-info">
                <strong>Sargyt belgisi:</strong> #{{ $order->order_number }} <br>
                <strong>Jemi baha:</strong> {{ number_format($order->total_price, 2) }}$ <br>
                <strong>Status:</strong> Kabul edildi
            </div>

            <p>Sargydyňyz ugradylanda size goşmaça bildiriş geler. Biz bilen bolanyňyz üçin minnetdar!</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/') }}" class="btn">Saýta dolanmak</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2026 Perfume-Art Collection. Ähli hukuklar goralan.</p>
            <p>Aşgabat ş., Türkmenistan</p>
        </div>
    </div>
</body>

</html>
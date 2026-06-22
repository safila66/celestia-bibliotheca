<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=EB+Garamond:wght@400;500;600&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-navy: #0d1025;
            --gold: #C9A84C;
            --ivory: #F8F5F0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: linear-gradient(135deg, #0d1025 0%, #1a1a2e 100%);
            color: var(--ivory);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }
        .container {
            background: rgba(30, 35, 45, 0.6);
            border: 1px solid var(--gold);
            padding: 40px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .icon {
            font-size: 64px;
            color: #4caf50;
            margin-bottom: 20px;
        }
        h1 {
            font-family: 'Cinzel', serif;
            color: var(--gold);
            font-size: 24px;
            margin-bottom: 15px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #ccc;
            margin-bottom: 30px;
        }
        .btn-close {
            background: var(--gold);
            color: #12100E;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }
        .btn-close:hover {
            background: #dfc16d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">✅</div>
        <h1><?= esc($title) ?></h1>
        <p><?= esc($message) ?></p>
        <button onclick="window.close()" class="btn-close">Tutup Halaman</button>
    </div>
</body>
</html>

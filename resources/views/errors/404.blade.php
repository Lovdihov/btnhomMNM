<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <style>
        :root {
            --bg-1: #090b1f;
            --bg-2: #161b3f;
            --accent-1: #5eead4;
            --accent-2: #f472b6;
            --text-main: #f8fafc;
            --text-muted: #cbd5e1;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at top right, #2c1f63 0%, transparent 40%),
                        radial-gradient(circle at left bottom, #0d4b55 0%, transparent 45%),
                        linear-gradient(135deg, var(--bg-1), var(--bg-2));
        }

        .card {
            width: min(760px, 100%);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(15, 20, 52, 0.72);
            backdrop-filter: blur(8px);
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            text-align: center;
        }

        h1 {
            margin: 14px 0 10px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.2;
        }

        p {
            margin: 0 auto;
            color: var(--text-muted);
            max-width: 560px;
            line-height: 1.6;
            font-size: 1rem;
        }

        .code {
            display: inline-block;
            margin-top: 4px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--accent-1);
        }

        .actions {
            margin-top: 26px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            border: 0;
            border-radius: 999px;
            text-decoration: none;
            padding: 12px 18px;
            font-weight: 700;
            transition: transform .2s ease, opacity .2s ease;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-primary {
            color: #081021;
            background: linear-gradient(90deg, var(--accent-1), #93c5fd);
        }

        .btn-muted {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .music-note {
            animation: bob 2.6s ease-in-out infinite;
            transform-origin: center;
        }

        @keyframes bob {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
    </style>
</head>
<body>
    <div class="card">
        <svg viewBox="0 0 420 220" width="100%" height="220" role="img" aria-label="Hình minh họa nhạc vui nhộn">
            <defs>
                <linearGradient id="disc" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#22d3ee" />
                    <stop offset="100%" stop-color="#a78bfa" />
                </linearGradient>
            </defs>
            <ellipse cx="210" cy="180" rx="130" ry="22" fill="rgba(0,0,0,0.35)"/>
            <circle cx="210" cy="112" r="70" fill="url(#disc)" opacity="0.95"/>
            <circle cx="210" cy="112" r="44" fill="#0f172a"/>
            <circle cx="210" cy="112" r="9" fill="#e2e8f0"/>
            <g class="music-note" fill="#f472b6">
                <path d="M310 56v58a16 16 0 1 1-10-14V65l36-8v47a16 16 0 1 1-10-14V51z"/>
            </g>
            <g class="music-note" fill="#5eead4" style="animation-delay:.5s">
                <path d="M86 74v45a12 12 0 1 1-8-11V83l30-7v36a12 12 0 1 1-8-11V72z"/>
            </g>
        </svg>

        <span class="code">404</span>
        <h1>Trang này đã lạc nhịp</h1>
        <p>
            Có vẻ liên kết bạn mở không còn tồn tại hoặc đã được di chuyển. Đừng lo,
            playlist vẫn đang chờ bạn quay lại.
        </p>

        <div class="actions">
            <a class="btn btn-primary" href="{{ route('home') }}">Về Trang Chủ</a>
            <a class="btn btn-muted" href="{{ url()->previous() }}">Quay Lại</a>
        </div>
    </div>
</body>
</html>
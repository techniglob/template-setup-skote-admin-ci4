<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            overflow: hidden;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 90%;
            animation: fadeIn 1s ease-in-out;
        }

        .error-code {
            font-size: clamp(4rem, 15vw, 8rem);
            font-weight: 700;
            color: #ff6b6b;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 1rem;
        }

        .message {
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            color: #333;
            margin-bottom: 1.5rem;
            line-height: 1.4;
        }

        .sub-message {
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            color: #666;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            font-size: clamp(0.9rem, 3vw, 1rem);
            color: #fff;
            background: #4a90e2;
            border-radius: 50px;
            text-decoration: none;
            transition: transform 0.3s, background 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 20%;
            animation-duration: 8s;
        }

        .circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 70%;
            animation-duration: 10s;
        }

        .circle:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 80%;
            left: 30%;
            animation-duration: 7s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
            }

            .error-code {
                font-size: clamp(3rem, 12vw, 6rem);
            }

            .message {
                font-size: clamp(1rem, 3.5vw, 1.5rem);
            }

            .sub-message {
                font-size: clamp(0.8rem, 2.5vw, 1rem);
            }

            .btn {
                padding: 0.7rem 1.2rem;
                font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            }

            .circle:nth-child(1) {
                width: 60px;
                height: 60px;
            }

            .circle:nth-child(2) {
                width: 90px;
                height: 90px;
            }

            .circle:nth-child(3) {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 400px) {
            .error-code {
                font-size: clamp(2.5rem, 10vw, 5rem);
            }

            .circle:nth-child(1) {
                width: 40px;
                height: 40px;
            }

            .circle:nth-child(2) {
                width: 60px;
                height: 60px;
            }

            .circle:nth-child(3) {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="container">
        <h1 class="error-code">404</h1>
        <p class="message">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= lang('Errors.sorryCannotFind') ?>
            <?php endif; ?>
        </p>
        <p class="sub-message">It looks like the page you're looking for doesn't exist or has been moved.</p>
        <a href="#" onclick="history.back()" class="btn">Back to Home</a>
    </div>
</body>

</html>
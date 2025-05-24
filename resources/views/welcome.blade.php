<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppName - The Perfect App For You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --text-color: #2b2d42;
            --light-text: #ffffff;
            --background: #ffffff;
            --section-bg: #f8f9fa;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        body {
            color: var(--text-color);
            background-color: var(--background);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            background: var(--gradient);
            color: var(--light-text);
            padding: 1.5rem 1rem;
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--light-text);
            text-decoration: none;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: var(--light-text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        nav a:hover {
            color: var(--accent-color);
        }

        /* Hero section */
        .hero {
            padding: 10rem 0 6rem;
            background: var(--gradient);
            color: var(--light-text);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/api/placeholder/1200/500') center/cover;
            opacity: 0.05;
        }

        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
        }

        h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-text {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        /* Phone mockup */
        .phone-mockup {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border-radius: 40px;
            overflow: hidden;
            background-color: #111;
            width: 280px;
            height: 570px;
            flex-shrink: 0;
            border: 8px solid #333;
            transform: perspective(1000px) rotateY(-15deg);
            transition: all 0.5s ease;
        }

        .phone-mockup:hover {
            transform: perspective(1000px) rotateY(0);
        }

        .phone-screen {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .phone-screen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CTA Buttons */
        .cta-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .button {
            padding: 0.8rem 1.8rem;
            background-color: var(--accent-color);
            color: var(--light-text);
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 201, 240, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .button i {
            font-size: 1rem;
        }

        .button:hover {
            background-color: #3ab4d9;
            transform: translateY(-3px);
        }

        .button-secondary {
            background-color: transparent;
            border: 2px solid var(--light-text);
            color: var(--light-text);
            box-shadow: none;
        }

        .button-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Footer */
        footer {
            background-color: #2b2d42;
            color: var(--light-text);
            text-align: center;
        }

        .copyright {
            padding: 3rem 0;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Media Queries */
        @media (max-width: 991px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .cta-buttons {
                justify-content: center;
            }

            .phone-mockup {
                transform: perspective(1000px) rotateY(0);
            }
        }

        @media (max-width: 767px) {
            h1 {
                font-size: 2.2rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .hero-text {
                font-size: 1rem;
            }

            .phone-mockup {
                width: 220px;
                height: 450px;
            }

            .button {
                padding: 0.7rem 1.4rem;
                font-size: 0.8rem;
            }
        }

        /* Basic Animation */
        .fade-in {
            animation: fadeIn 0.8s ease forwards;
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

        .delay-2 {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body>
    <header id="header">
        <div class="container header-content">
            <a href="#" class="logo">{{ strtoupper(env('APP_NAME')) }}</a>
            <nav>
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-dark">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-dark">Login</a>
                @endif
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content fade-in">
                <h1>Experience the Future with AppName</h1>
                <p class="hero-text">The perfect app that solves your problems with innovative features and intuitive design. Download now and transform the way you work.</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-download"></i>
                        Download Now
                    </a>
                    <a href="#features" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
            <div class="phone-mockup fade-in delay-2">
                <div class="phone-screen">
                    <img src="{{ asset('default/screen.jpg') }}" alt="App Screenshot" />
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="copyright">
            <p>&copy; 2025 AppName. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>


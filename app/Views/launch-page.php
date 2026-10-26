<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $page_header ?? 'ECOEX App' ?></title>
    <meta name="description" content="<?= $general_settings->meta_description ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="<?= getenv('app.uploadsURL') . $general_settings->site_favicon ?>" rel="icon">
    <link href="<?= getenv('app.uploadsURL' . $general_settings->site_favicon) ?>" rel="apple-touch-icon">
    <style>
        :root {
            --primary: #4CAF50;
            --dark: #2E7D32;
            --light: #CDEB6A;
            --accent: #6BCF8E;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(205, 235, 106, 0.25), transparent 40%),
                radial-gradient(circle at bottom right, rgba(76, 175, 80, 0.25), transparent 45%),
                linear-gradient(135deg, #f4fff6, #e8f5e9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1100px;
            background: var(--white);
            border-radius: 18px;
            padding: 50px;
            display: flex;
            gap: 50px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
        }

        .content {
            flex: 1;
        }

        .logo {
            height: 60px;
            margin-bottom: 25px;
        }

        .content h1 {
            font-size: 2.6rem;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .content p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #444;
            margin-bottom: 30px;
        }

        .store-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
            /* justify-content: space-between; */
        }

        .store-buttons a {
            /* padding: 14px 26px; */
            border-radius: 10px;
            /* background: var(--primary); */
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s ease;
        }

        /* .store-buttons a:hover {
            background: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(76, 175, 80, 0.35);
        } */

        .store-buttons img {
            height: 50px;
            width: 100%;
        }

        .preview {
            flex: 1;
            text-align: center;
        }

        .preview img {
            max-width: 320px;
            width: 100%;
            border-radius: 22px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        @media(max-width:768px) {
            .container {
                text-align: center;
                padding: 35px 25px;
            }

            .store-buttons {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="content">
            <img src="<?= getenv('app.uploadsURL') . $general_settings->site_logo ?>" class="logo" alt="<?= $general_settings->site_name ?>">

            <h1>Smart. Green. Efficient.</h1>

            <p>
                <?= (($page_content) ? $page_content->long_description : '') ?>
            </p>

            <div class="store-buttons">
                <a href="https://play.google.com/store/apps/details?id=com.ecoexvendor.keyline" target="_blank">
                    <img src="<?= base_url('public/play-store.png') ?>">
                </a>

                <a href="https://apps.apple.com/in/app/ecoex-buyer/id6498938548" target="_blank">
                    <img src="<?= base_url('public/app-store.png') ?>">
                </a>
            </div>
        </div>

        <!-- <div class="preview">
            <img src="<?= getenv('app.uploadsURL') ?>app-preview.png" alt="App Screenshot">
        </div> -->

    </div>

</body>

</html>
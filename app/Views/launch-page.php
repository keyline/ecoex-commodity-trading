<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$page_header?></title>
    <meta name="description" content="<?=$general_settings->meta_description?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="<?=getenv('app.uploadsURL').$general_settings->site_favicon?>" rel="icon">
    <link href="<?=getenv('app.uploadsURL'.$general_settings->site_favicon)?>" rel="apple-touch-icon">
</head>
<body>

    <div style="text-align:center;">
        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>">
        <p><?=(($page_content)?$page_content->long_description:'')?></p>
    </div>
</body>
</html>

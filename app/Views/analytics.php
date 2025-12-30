<?php
use App\Models\CommonModel;
$this->common_model         = new CommonModel;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Favicons -->
    <link href="<?=getenv('app.uploadsURL').$general_settings->site_favicon?>" rel="icon">
    <link href="<?=getenv('app.uploadsURL'.$general_settings->site_favicon)?>" rel="apple-touch-icon">
</head>
<body>
<div class="container-fluid mt-4">

</div>
</body>
</html>
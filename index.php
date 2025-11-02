<?php 
    require_once 'function.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $web_title; ?></title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
</head>
<body>

    <div class="container">
        <div class="card border-0">
            <div class="card-body">
                <h1 class="card-title text-center mb-4"><?php echo $web_title; ?></h1>
                <?php if ($err): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($err as $e): ?>
                                <li><?php echo htmlspecialchars($e); ?></li>
                            <?php endforeach; ?>
                        </ul>
                <?php endif; ?>
                <?php if ($dlUrl): ?>
                    <div class="alert alert-success">
                        <p class="alert alert-success mb-2 mt-2">
                            Conversion successful!
                        </p>
                        Your file is ready: <a href="<?php echo htmlspecialchars($dlUrl); ?>" download>Download Here</a>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="url" class="form-label">Youtube URL:</label>
                        <input type="url" name="url" placeholder="https://www.youtube.com/watch?v=..." required
                        class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="convertTo" class="form-label">Convert To:</label>
                        <select name="format" class="form-control">
                            <option value="mp3">MP3 (Audio)</option>
                            <option value="mp4">MP4 (Video)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Convert Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>
</html>
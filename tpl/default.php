<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Url Minifier</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <header>
        <h1>
            <?php echo $this->renderHeader(); ?>
        </h1>
    </header><!-- end header -->

    <?php if (!empty($this->errors)): ?>
        <div class="alert alert-warning">
            <ul>
                <?php foreach ($this->errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="container">
        <form action="/" method="POST" class="form-horizontal">
            <div class="form-group">
                <label for="url" class="col-sm-2 control-label">URL:</label>
                <div class="col-sm-10">
                    <input name="url" type="text" class="form-control" value="<?php echo $this->getUrl(); ?>" placeholder="Enter url you want to minify">
                </div>
            </div>

            <div class="form-group">
                <label for="short_url" class="col-sm-2 control-label">
                    http://<?php echo $_SERVER['HTTP_HOST']; ?>/
                </label>
                <div class="col-sm-10">
                    <input name="short_url" type="text" class="form-control" value="<?php echo $this->getShortUrl(); ?>" placeholder="Here you can add your short link">
                </div>

            </div>

            <div class="form-group">
                <label for="expire_date" class="col-sm-2 control-label">Expire date:</label>
                <div class="col-sm-2">
                    <input name="expire_date" type="date" class="form-control" value="<?php echo $this->getExpireDate(); ?>">
                </div>
            </div>

            <div class="form-group">
                <?php if (empty($this->short_url)): ?>
                    <input type="submit" value="Generate" class="btn btn-primary">
                <?php else: ?>
                    <a href="/" class="btn btn-primary">&larr; Back to main</a>
                <?php endif ?>
            </div>
        </form>
    </div><!-- end .container -->

    <footer>
        <script href="/bootstrap/js/bootstrap.min.js"></script>
    </footer><!-- end footer -->
</body>
</html>

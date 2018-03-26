<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/style.css">
    <title><?php echo $title; ?></title>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://<?php echo $_SERVER['HTTP_HOST'];?>">Web site</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>">Home</a></li>
    </ul>
<?php if (isset($_SESSION['id'])): ?>
  <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/logout" class="btn btn-default  navbar-btn">Logout</a>
	<a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/news/create" class="btn btn-success navbar-btn">Add news</a>
<?php else: ?>
    <form class="navbar-form navbar-right" action="http://<?php echo $_SERVER['HTTP_HOST'];?>/login" method="post">
      <div class="form-group">
        <input type="email" class="form-control" placeholder="email..." name ="email" required>
		<input type="password" class="form-control" placeholder="password..." name="password" required>
      </div>
      <button type="submit" class="btn btn-default">Login</button>
    </form>
<?php endif; ?>
  </div>
</nav>

<main>
	<?php include $contentView; ?>
</main>

<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/jquery-2.0.0.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/bootstrap.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/script.js"></script>
</body>
</html>
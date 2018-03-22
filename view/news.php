<h1>News page</h1>

<?php 
    if (isset($data)): 
    foreach ($data['news'] as $news):
?>
    <div class="panel panel-default news">
            <div class="panel-heading">
                <?php echo $news['title'] ?>
                <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $news['user_id']): ?>
                    <a href="http://<?php echo ENV_URL . '/news/edit/?id=' . $news['id']; ?>" class="btn btn-xs btn-warning pull-right">EDIT</a>
                    <a href="http://<?php echo ENV_URL . '/news/delete/?id=' . $news['id']; ?>" class="btn btn-xs btn-danger pull-right">DELETE</a>
                <?php endif; ?>
            </div>
                <div class="panel-body">
                    <?php if (!is_null($news['image'])): ?>
                        <img src="http://<?php echo ENV_URL . '/' . $news['image']; ?>" class="img-rounded news-image" alt="<?php echo $news['title']; ?>">
                    <?php endif; ?>
                    <?php echo $news['message']; ?>
                </div>
            </div>
        </div>
<?php 
    endforeach;
    endif;
?>
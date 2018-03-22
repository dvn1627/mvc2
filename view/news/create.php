<h1 class="h1 text-center">
    <?php 
    echo isset($data) ?  'Editing news' : 'Creating news';
    ?>
</h1>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php 
            echo isset($data) ?  'Editing news' : 'Creating news';
        ?>
    </div>
        <div class="panel-body">

            <?php if (isset($data)): ?>
                <form class="" method="POST" action="http://<?php echo ENV_URL . '/news/update'; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value=<?php echo $data->get('id')?> >
            <?php else: ?>
                <form class="" method="POST" action="http://<?php echo ENV_URL ?>/news/store" enctype="multipart/form-data">
            <?php endif; ?>

                <label for="message">Title:</label>
                
                <?php if (isset($data)): ?>
                    <input type="text" class="form-control" name="title" placeholder="title..." required value="<?php echo $data->get('title'); ?>">
                <?php else: ?>
                    <input type="text" class="form-control" name="title" placeholder="title..." required>
                <?php endif; ?>

                <label for="message">Message:</label>

                <?php if (isset($data)): ?>
                    <textarea class="form-control" name="message" id="message"><?php echo $data->get('message'); ?></textarea>
                <?php else: ?>
                    <textarea class="form-control" name="message" id="message"></textarea>
                <?php endif; ?>

                <input type="file" name="image" class="form-control">

                <?php if (isset($data) && !is_null($data->get('image'))): ?>
                    <img src="http://<?php echo ENV_URL . '/' . $data->get('image'); ?>" class="img-rounded news-image" alt="<?php echo $data->get('title'); ?>">
                <?php endif; ?>

                <input type="submit" name="SAVE NEWS"  class="btn btn-default pull-right" value="SAVE NEWS">
            </form>
        </div>
    </div>
</div>
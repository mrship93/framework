<div class="container">
   <?php foreach($posts as $post): ?>
       <div class="panel panel-default">
           <div class="panel-body"><?= $post['title'];  ?></div>
           <div class="panel-footer"><?= $post['text'];  ?></div>
       </div>

    <?php endforeach; ?>
</div>

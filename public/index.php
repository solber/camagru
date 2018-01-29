<?php require_once "required/header.php"; ?>
<?php require_once "required/functions.php"; ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class="content">
      <div class="container">

        <?php 
            require_once 'required/database.php';
            foreach($pdo->query('SELECT * FROM images ORDER BY posted_date DESC') as $row)
            {
                $req = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                if ($req->execute(['id' => $row->owner_id]))
                {
                    $username = $req->fetch();
                }
                else
                {
                    put_flash('danger', "Error while querying the DB.", "/index.php");
                }

                $nblike = 0;
                $liked_by_me = false;
               
                foreach ($pdo->query('SELECT * FROM likes WHERE img_id = ' .$row->id) as $likerow) {
                    $nblike++;
                    if (isset($_SESSION['auth'])){
                        if ($likerow->owner_like_id == $_SESSION['auth']->id){
                            $liked_by_me = true;
                        }
                    }
                }
            ?>

            <div class="auteur"><p style="z-index: 1"><?php echo htmlspecialchars($username->username); ?></p></div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a5e99b6e436894e"></script>
            <center><img src="<?php echo $row->img_path; ?>" width="50%"></center>
            <?php if (isset($_SESSION['auth'])): ?>
            <form method="POST" action="like.php">
                <input name="img_id" value="<?php echo $row->id; ?>" style="display: none;">
            <?php endif; ?>
                <div class="like">
                    <?php 
                    if (isset($_SESSION['auth'])) {
                        if (!$liked_by_me) { ?>
                            <input type="submit" class="btn-like-none" name="like" value="❤">
                        <?php }else{ ?>
                            <input type="submit" class="btn-like" name="like" value="❤">
                        <?php } }else{ ?>
                            <br>
                        <?php } ?>
                    <label style="position: relative; bottom: 8px;"><?php echo $nblike; ?> likes</label>
                    <?php if (isset($_SESSION['auth'])) {
                            if ($_SESSION['auth']->id == $row->owner_id){ ?>
                                <a href="delete.php?img_id=<?php echo $row->id; ?>" style="position: relative; bottom: 9px; left: 10px; font-size: 12px;">Delete</a>
                            <?php }
                        } ?>
                </div>
            </form>
                <div class="comment">
                    <?php 
                        foreach ($pdo->query("SELECT * FROM comments WHERE img_id = $row->id ORDER BY posted_date DESC") as $comment) { 
                            $req = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                            if ($req->execute(['id' => $comment->owner_comment]))
                            {
                                $username = $req->fetch();
                            }
                            else
                            {
                                put_flash('danger', "Error while querying the DB.", "/index.php");
                            }

                    ?>
                        <span class="comment-line"><p><label class="auteur"><?php echo htmlspecialchars($username->username); ?></label>: <label><?php echo htmlspecialchars(utf8_encode($comment->comment_text)); ?></label></p></span>
                    <?php } ?>
                    <?php if (isset($_SESSION['auth'])) { ?>
                    <form method="POST" action="comment.php">
                        <input name="img_id" value="<?php echo $row->id; ?>" style="display: none;">
                        <input type="text" class="comment-field" name="comment" placeholder="Your comment ..">
                        <input type="submit" class="btn-commenta" name="btn-comment" value="Send">
                    </form>
                    <?php } ?>
                </div>
            <?php
            }
        ?>
      </div>
    </div>
  </body>
</html>

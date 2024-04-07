


    <div class="post">
        <div class="post-header">
      
        <?php
        $post_image = $row_user['userimg'];
        echo "<img src='$post_image' alt='Profile Image' class='profile-image'>";
        ?>

            <h3><?php echo $row_user['username']?></h3>
        </div>
        <div class = "post-content"> 
            <?php
            if($row['bot_serial']) {
                echo "Bot Serial Number: " . $row['bot_serial'];
            }
            ?>
        </div>
        <div class="post-content">
            <p><?php echo $row['post']?></p>
        </div>
        <div class="post-actions">
            <button class="like-button" onclick="window.location.href = 'like.php?id=<?php echo $row['postid'];?>'">Like</button>
            <span class="likes-count">
                <?php $post = new Post(); 
                echo "Likes: " . $post->get_likes($row['postid']);
                ?>
                <br></span>
        </div>
        <span> <?php echo $row['date'] ?></span>
        <?php

        $post_image = $row['image'];

        echo"<img src = '$post_image' style='width:100%'>"
        ?>
        
    </div>


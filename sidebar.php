<div class="content-side">
    <div class="side-box">
        <?php dynamic_sidebar('primary-widget-area'); ?>
        <aside class="side-inner">
            <h4 class="title">ユーザー一覧</h4>
            <?php
            $users = get_users(array(
                'orderby' => 'ID',
                'order' => 'DESC',
            ));
            ?>
            <ul class='users_list'>
                <?php 
                    foreach ($users as $user) :
                    $uid = $user->ID;
                ?>
                    <li><a href="<?php echo esc_url(home_url()).'/forums/users/'.$user->display_name; ?>"><?php echo $user->display_name ; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</div>
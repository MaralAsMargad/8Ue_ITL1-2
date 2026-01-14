<div class="container">
    <h1>MessageController/index</h1>

    <div class="box">
        <table class="overview-table">
            <thead>
                <tr>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>New</td>
                </tr>
            </thead>

            <?php foreach ($this->users as $user): ?>
                <tr>
                    <!-- Avatar -->
                    <td class="avatar">
                        <?php if (isset($user->user_avatar_link)) { ?>
                            <img src="<?= $user->user_avatar_link; ?>" />
                        <?php } ?>
                    </td>

                    <!-- Username -->
                    <td>
                        <a href="<?= Config::get('URL') ?>message/chat/<?= $user->user_id ?>">
                            <?= htmlspecialchars($user->user_name); ?>
                        </a>
                    </td>

                    <!-- Unread counter -->
                    <td>
                        <?php if ($user->unread_count > 0): ?>
                            <span style="
                                background:red;
                                color:white;
                                border-radius:50%;
                                padding:3px 7px;
                                font-size:12px;
                            ">
                                <?= $user->unread_count; ?>
                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>

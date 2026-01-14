<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <?php 
        // get all available account_types from database (see UserModel)
        $availableAccTypes = UserModel::getAvailableAccountTypes();
        ?>
        
        <div>
            This controller/action/view shows a list of all users in the system. with the ability to soft delete a user
            or suspend a user.
        </div>
        <div>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>Activated ?</td>
                    <td>Link to user's profile</td>
                    <td>Account Type</td>
                    <td>suspension Time in days</td>
                    <td>Soft delete</td>
                    <td>Submit</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>"/>
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                        <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
                        </td>
                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
                            <td>
                                <? /* Account Type Select added to existing form */?>
                                <select name="account_type" id="account_type">
                                    <? /* loop through all types and create corresponding options */?>
                                    <? foreach ($availableAccTypes as $type) :
                                        // check if user has current role
                                        if ($type->account_type === $user->account_type) : ?>
                                            <? 
                                            /* 
                                            set option as selected
                                            $type->account_type = account type "id"
                                            $type->lang = "name" string (e.g. Admin)
                                            */
                                            ?>
                                            <option value="<?= $type->account_type; ?>" selected="selected">
                                                <?= $type->lang; ?>
                                            </option>
                                        <? else : ?>
                                            <option value="<?= $type->account_type; ?>">
                                                <?= $type->lang; ?>
                                            </option>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </select>
                            </td>
                                                        
                            <!-- need? no need? idk 

                            <td><input type="number" name="suspension" /></td>
                            <td><input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> /></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                <input type="submit" />
                            </td> -->
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

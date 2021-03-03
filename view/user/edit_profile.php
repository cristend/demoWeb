<?php
if (isset($_SESSION["user"])) {
    include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
    $user = get_user($_SESSION["user"], $user_model);
?>
    <script>
        $(function() {
            $("form[name=edit-profile]").on("submit", function() {
                $.ajax({
                    type: 'post',
                    url: '/controller/edit_user.php',
                    data: $('form').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.location) {
                            alert("update profile successfully!");
                            window.location.href = response.location;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });
            })
        });
    </script>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <h1 class="bold uppercase">User profile</h1>
                </div>
            </div>
            <div class="portlet-body">
                <div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <form id="edit-profile" name="edit-profile" class="register-form" action="" method="post">
                                <div class="form-group">
                                    <label for="password" class="text-info">Name</label><br>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo $user["name"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Bio</label><br>
                                    <input type="text" name="bio" id="bio" class="form-control" placeholder="<?php echo $user["bio"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="sex" class="text-info">Sex</label><br>
                                    <select class="form-select" name="sex" aria-label="Default select example">
                                        <?php
                                        $sex_list = ["male", "female", "other"];
                                        foreach ($sex_list as $sex) {
                                            if ($sex == $user["sex"]) {
                                                echo '<option selected value="' . $user["sex"] . '">' . $user["sex"] . '</option>';
                                            } else {
                                                echo '<option value="' . $sex . '">' . $sex . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Phone</label><br>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="<?php echo $user["phone"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Birth Day</label><br>
                                    <input type="text" class="form-control" placeholder="<?php echo $user["birth"]; ?>" onfocus="(this.type='date')" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Update">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
<?php
} else {
    header("Location: /404.php");
}

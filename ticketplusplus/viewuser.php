<?php $title = 'Administration - Ticketplusplus'; ?>
<?php $currentPage = 'administration'; ?>
<?php include_once 'includes/changeuser.inc.php'; ?>
<?php include('head.php'); ?>
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php if ($roleperm == 3): ?>
<?php include('nav-bar.php'); ?>
<?php include('nav-bar-admin.php'); ?>

<?php $uid = isset($_GET['userid']) ? $_GET['userid'] : '' ?>

<?php if (isset($_GET['msgid'])) {
        if ($_GET['msgid'] == 1) {
            $modalTitel = 'Erfolgreich!';
            $modalMessage = 'Der User wurde erfolgreich geändert!';
        }
        else if ($_GET['msgid'] == 2) {
            $modalTitel = 'Upsi!';
            $modalMessage = "Leider ist beim Ändern des Users ein Fehler aufgetreten. Fehlercode: $sql";
        }
        else if ($_GET['msgid'] == 3) {
            $modalTitel = 'Upsi!';
            $modalMessage = "Die eingebene Email ist nicht gültig";
        }
    }
?>

<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<div class="container-fluid">
        <div class="row">

            <?php if (!empty($modalMessage)) : ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#messageModal").modal('show');
                    });
                </script>
            <?php endif; ?>
            
            <!-- SUCCESS MODAL -->
            <div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle"><?php if (!empty($modalTitel)){echo $modalTitel; }?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($modalMessage)){echo $modalMessage;} ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SUCCESS MODAL END -->

            <form id="changeUserForm" class="mt-3 ml-3" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="user_info" class="h3 ml-5 mt-3">Informationen</label>
                <div id="user_info">
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Benutzer ID </i>
                        </div>
                        <input id="userid" type="text" name="userid" value="<?php
                            $stmt = "SELECT DISTINCT id FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                echo $temp;
                            }?>" class="form-control col-6" readonly="readonly">
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Benutzername </i>
                        </div>
                        <input id="username" type="text" name="username" value="<?php
                            $stmt = "SELECT DISTINCT username FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                echo $temp;
                            }?>" class="form-control col-6">
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text">Vorname</i>
                        </div>
                        <input id="uservorname" type="text" name="uservorname" value="<?php
                            $stmt = "SELECT DISTINCT vorname FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                $vorname = $temp;
                                echo $temp;
                            }?>" class="form-control col-6">
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Nachname </i>
                        </div>
                        <input id="usernachname" type="text" name="usernachname" value="<?php
                            $stmt = "SELECT DISTINCT nachname FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                $nachname = $temp;
                                echo $temp;
                            }?>" class="form-control col-6">
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Abteilung </i>
                        </div>
                        <select class="form-control col-6 custom-select d-block w-100" id="dept_menu" name="dept_menu" required >
                            <?php
                                $stmt = "SELECT DISTINCT dept_id FROM ticketplusplus.users WHERE id =  $uid";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($temp) = mysqli_fetch_row($result)){
                                    $deptID = $temp;
                                }

                                $stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.department WHERE dept_id =  $deptID";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($temp) = mysqli_fetch_row($result)){
                                    $deptName = $temp;
                                }	
                                $stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.department";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($category) = mysqli_fetch_row($result)){
                                    if ($deptName == $category){
                                        echo '<option value="'.$category.'" selected>'.$category.'</option>';
                                    }
                                    else {
                                        echo '<option value="'.$category.'">'.$category.'</option>';
                                    }
                                }
                            ?> 
                        </select>
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Rolle </i>
                        </div>
                        <select class="form-control col-6 custom-select d-block w-100" id="role_menu" name="role_menu" required >
                            <?php
                                $stmt = "SELECT DISTINCT role_id FROM ticketplusplus.users WHERE id =  $uid";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($temp) = mysqli_fetch_row($result)){
                                    $roleID = $temp;
                                }

                                $stmt = "SELECT DISTINCT role_name FROM ticketplusplus.roles WHERE role_id =  $roleID";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($temp) = mysqli_fetch_row($result)){
                                    $roleName = $temp;
                                }	
                                $stmt = "SELECT DISTINCT role_name FROM ticketplusplus.roles";
                                $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                                while(list($category) = mysqli_fetch_row($result)){
                                    if ($roleName == $category){
                                        echo '<option value="'.$category.'" selected>'.$category.'</option>';
                                    }
                                    else {
                                        echo '<option value="'.$category.'">'.$category.'</option>';
                                    }
                                }
                            ?> 
                        </select>
                    </div>
                </div>
                <label for="kontanktdaten" class="h3 ml-5 mt-3">Kontakt</label>
                <div id="kontanktdaten">
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> Telefonnummer </i>
                        </div>
                        <input id="telnr" type="text" name="telnr" value="<?php
                            $stmt = "SELECT DISTINCT telefonnummer FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                echo $temp;
                            }?>" class="form-control col-7">
                    </div>
                    <div class="ml-5 mt-2 input-group">
                        <div class="input-group-prepend">
                            <i class="input-group-text"> E-Mail </i>
                        </div>
                        <input id="email" type="text" name="email" value="<?php
                            $stmt = "SELECT DISTINCT email FROM ticketplusplus.users WHERE id =  $uid";
                            $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
                            while(list($temp) = mysqli_fetch_row($result)){
                                echo $temp;
                            }?>" class="form-control col-7">
                    </div>
                </div>

                <div id="Buttons">
                        <button type="button" class="btn btn-secondary ml-5 mt-2" value="Change" onclick="return changeuser(this.form, this.form.userid.value, this.form.username.value, this.form.uservorname.value, this.form.usernachname.value, this.form.dept_menu.value, this.form.role_menu.value, this.form.telnr.value, this.form.email.value);">Ändern</button>
                        <button type="button" class="btn btn-danger ml-5 mt-2" value="Löschen" data-toggle="modal" data-target="#deleteModal">Löschen</button>
                </div>

                <!-- DELETE MODAL START -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle2">Löschen bestätigen</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Wollen Sie den User <?php echo "$vorname $nachname" ?> wirklich Löschen?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" value="Delete" onclick="return deleteuser(this.form, this.form.userid.value);">Löschen</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DELETE MODAL END -->

            </form>
        </div> <!-- CLOSE ROW -->
    </div> <!-- CLOSE CONTAINER FLUID -->
</main>

	<?php else : ?>
	<p>
		<span class="error">Sie haben nicht die Berechtigung diese Seite aufzurufen. <a href="home.php">Zurück zur Startseite</a>.
	</p>
<?php endif; ?>

<?php else : ?>
	<p>
		<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
	</p>
<?php endif; ?>

<?php include('footer.php'); ?>
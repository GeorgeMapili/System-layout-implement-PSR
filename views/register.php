<?php require_once(__DIR__. "/layouts/header.php") ?>

<div class="container">
    <div class="card row mt-5 col-lg-4 offset-lg-4">
        <div class="card-header">
            Register
        </div>
        <div class="card-body">
            <form id="register">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                    <small></small>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                    <small></small>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <small></small>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small></small>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <small></small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="./js/register.js" defer></script>
<?php require_once(__DIR__. "/layouts/footer.php") ?>
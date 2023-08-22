<div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; ">
    <form method="post" style="width: 50%;">
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <input class="input" type="text" placeholder="User" name="user" >
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input class="input" type="password" placeholder="Password" name="password">
                <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
                </span>
            </p>
        </div>
            <p class="control" style="margin-bottom: 20px;"> 
                <button class="button is-success" style="width: 200px; border-radius: 8px">
                    Login
                </button>
            </p>
        <?php
            if (isset($_POST["user"]) && isset($_POST["password"]) ) {
                require_once "./php/main.php";
                require_once "./php/login_session.php";
            }
        ?>
    </form>
</div>

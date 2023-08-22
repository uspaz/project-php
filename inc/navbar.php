<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './inc/head.php';?>
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?view=home">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
     
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
                Users
            </a>

            <div class="navbar-dropdown">
                <a class="navbar-item" href="index.php?view=new_user">New</a>
                <a class="navbar-item" href="index.php?view=list_users">List</a>
                <a class="navbar-item" href="index.php?view=user_search">Search</a>
            </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
                Category
            </a>

            <div class="navbar-dropdown">
                <a class="navbar-item" href="index.php?view=new_category">New</a>
                <a class="navbar-item" href="index.php?view=category_list">List</a>
                <a class="navbar-item" href="index.php?view=category_search">Search</a>
            </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
                Products
            </a>

            <div class="navbar-dropdown">
                <a class="navbar-item">New</a>
                <a class="navbar-item">List</a>
                <a class="navbar-item">By Category</a>
                <a class="navbar-item">Search</a>
            </div>
        </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?view=update_user&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
            Account
          </a>
          <a href="index.php?view=logout" class="button is-light is-rounded">
            LogOut
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
</body>
</html>
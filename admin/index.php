<?php

require_once "../config/config.php";

session_start();


if(!isset($_SESSION['admin'])){


    if(isset($_POST['id']) && $_POST['id']==ADMIN_ID){

        $_SESSION['admin']=true;

    }else{

        ?>

        <form method="post">

        <h3>Admin Login</h3>

        <input name="id" placeholder="Admin ID">

        <button>
        Login
        </button>

        </form>

        <?php

        exit;

    }

}


?>

<h2>
Hetzner Shop Admin Panel
</h2>


<ul>

<li>
<a href="users.php">
Users
</a>
</li>


<li>
<a href="payments.php">
Payments
</a>
</li>


<li>
<a href="servers.php">
Servers
</a>
</li>


</ul>

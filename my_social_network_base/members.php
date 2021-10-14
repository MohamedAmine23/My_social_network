<?php
    require_once "functions.php";
    
   
    check_login();

    $members=get_members()
    
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Members</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <div class="title">Other Members</div>
        <?php include 'menu.html' ?>
        <div class="main">
       
            <ul>
                <?php foreach($members as $member){?>
                        <li>
                            <a href="profile.php?pseudo=<?=$member['pseudo']?>"><?=$member['pseudo'] ?></a>
                        </li>
                <?php }?>
            </ul>
            
        </div>
    </body>
</html>
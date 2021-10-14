<?php
    require_once "functions.php";
    
   
    check_login();
    $members=get_members();
    //5:51 - 6:27
    
    $filter="";
    if(isset($_GET["filter"])){
        $filter=$_GET["filter"];
        if(isset($_GET["action"])){

            if($_GET["action"]=="Apply"){
                $members=selection_filter($filter);
            }
            else if($_GET["action"]=="Clear"){
                $filter='';
                $members=get_members();
            }    
        }
        
    }
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
        <form action="members.php" method="GET">
            <label>Filter:</label><input type="text" value="<?=$filter?>" name="filter">
            <input type="submit" value="Apply" name="action">&nbsp;<input type="submit"  name="action" value="Clear">
        </form>
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
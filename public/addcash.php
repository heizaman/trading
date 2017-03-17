<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("addcash_form.php", ["title" => "Add Cash"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $addcash = $_POST["addcash"];
        
        if (empty($addcash) || ! preg_match("/^\d+$/", $addcash))
        {
            apologize("Please provide a valid cash value.");
        }
        
        $user_id = $_SESSION["id"];
        
        CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $addcash, $user_id);
        
        redirect("/");
    }

?>

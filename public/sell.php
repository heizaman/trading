<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "Sell"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $symbol = $_POST["symbol"];
        
        if (empty($symbol))
        {
            apologize("Please provide a quote symbol.");
        }
        
        $symbol = strtoupper($symbol);
        $user_id = $_SESSION["id"];
        $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ? AND symbol = ?", $user_id, $symbol);
        
        if(count($rows) == 0) {
            apologize("You don't have any shares of this stock.");
        }
        
        $shares = $rows[0]["shares"];
        $stock = lookup($_POST["symbol"]);
        
        if($stock === false) {
            apologize("Unexpected error occurred!");
        }
        
        $cash_add = $shares * $stock["price"];
        
        CS50::query("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $user_id, $symbol);
        CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $cash_add, $user_id);
        
        // add to transactions table
        CS50::query("INSERT INTO transactions (user_id, symbol, shares, price, type, timestamp) VALUES (?, ?, ?, ?, 'Sold', DEFAULT)", $user_id, $symbol, $shares, $stock["price"]);
        
        redirect("/");
    }

?>

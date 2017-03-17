<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $symbol = $_POST["symbol"];
        $buyshares = $_POST["shares"];
        
        if (empty($symbol))
        {
            apologize("Please provide a quote symbol.");
        }
        if (empty($buyshares) || ! preg_match("/^\d+$/", $buyshares))
        {
            apologize("Please provide valid number of shares.");
        }
        
        $symbol = strtoupper($symbol);
        $user_id = $_SESSION["id"];
        $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ? AND symbol = ?", $user_id, $symbol);
        
        $shares = 0;
        
        if(count($rows)) {
            $shares = $rows[0]["shares"];
        }
        
        $stock = lookup($_POST["symbol"]);
        
        if($stock === false) {
            apologize("Invalid symbol.");
        }
        
        $cash_deduct = $buyshares * $stock["price"];
        $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $user_id);
        $cash = $rows[0]["cash"];
        
        if($cash < $cash_deduct) {
            apologize("Not enough cash!");
        }
        $cash = $cash - $cash_deduct;
        
        if($shares == 0) {
            CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES (?, ?, ?)", $user_id, $symbol, $buyshares);
        } else {
            CS50::query("UPDATE portfolios SET shares = shares + ? WHERE user_id = ? AND symbol = ?", $buyshares, $user_id, $symbol);
        }
        // or we can use:
        // INSERT INTO portfolios (user_id, symbol, shares) VALUES(9, 'FREE', 10) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)
        
        CS50::query("UPDATE users SET cash = ? WHERE id = ?", $cash, $user_id);
        
        // add to transactions table
        CS50::query("INSERT INTO transactions (user_id, symbol, shares, price, type, timestamp) VALUES (?, ?, ?, ?, 'Bought', DEFAULT)", $user_id, $symbol, $buyshares, $stock["price"]);
        
        redirect("/");
    }

?>

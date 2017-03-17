<?php

    // configuration
    require("../includes/config.php");
    
    $user_id = $_SESSION["id"];
    $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $user_id);
    
    $portfolio = array();
    
    foreach ($rows as $row) {
        $quote = array();
        $quote["symbol"] = $row["symbol"];
        $quote["shares"] = $row["shares"];
        $stock = lookup($quote["symbol"]);
        if($stock) {
            $quote["name"] = $stock["name"];
            $quote["price"] = number_format($stock["price"], 4);
            array_push($portfolio, $quote);
        }
    }
    
    $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $user_id);
    if(count($rows)) {
        $cash = $rows[0]["cash"];
    }

    // render portfolio
    render("portfolio.php", ["title" => "Portfolio", "positions" => $portfolio, "cash" => $cash ]);

?>

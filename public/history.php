<?php

    // configuration
    require("../includes/config.php");
    
    $user_id = $_SESSION["id"];
    $rows = CS50::query("SELECT * FROM transactions WHERE user_id = ?", $user_id);
    
    $transactions = array();
    
    foreach ($rows as $row) {
        $transaction = array();
        $transaction["symbol"] = $row["symbol"];
        $transaction["shares"] = $row["shares"];
        $transaction["type"] = $row["type"];
        $transaction["price"] = number_format($row["price"], 4);
        $transaction["time"] = $row["timestamp"];
        array_push($transactions, $transaction);
    }

    // render portfolio
    render("history.php", ["title" => "History", "transactions" => $transactions ]);

?>

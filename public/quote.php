<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "Quote"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("Please provide a quote symbol.");
        }

        // query database for user
        $stock = lookup($_POST["symbol"]);
        
        if($stock === false) {
            apologize("Please provide a valid quote symbol.");
        }

        render("quote_price.php", ["name" => $stock["name"], "symbol" => $stock["symbol"], "price" => number_format($stock["price"], 4) ]);
    }

?>

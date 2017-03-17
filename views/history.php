<div>
    
    <p>

        <table>
            
            <tr>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Price</th>
                <th>Type</th>
                <th>Time</th>
            </tr>
            
            <?php
        
                foreach ($transactions as $transaction)
                {
                    print("<tr>");
                    print("<td>" . $transaction["symbol"] . "</td>");
                    print("<td>" . $transaction["shares"] . "</td>");
                    print("<td>" . $transaction["price"] . "</td>");
                    print("<td>" . $transaction["type"] . "</td>");
                    print("<td>" . $transaction["time"] . "</td>");
                    print("</tr>");
                }
        
            ?>
        </table>
    
    </p>


</div>

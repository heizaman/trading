<div>
    
    <p>

        <table>
            
            <tr>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Price</th>
            </tr>
            
            <?php
        
                foreach ($positions as $position)
                {
                    print("<tr>");
                    print("<td>" . $position["symbol"] . "</td>");
                    print("<td>" . $position["shares"] . "</td>");
                    print("<td>" . $position["price"] . "</td>");
                    print("</tr>");
                }
        
            ?>
        </table>
    
    </p>
    
    <br/>
    
    <h3>Cash Balance: <?= $cash ?></h3>


</div>

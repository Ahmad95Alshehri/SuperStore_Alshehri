<?php
include('header.php');

if (isset($_POST["category_choice"]) && isset($_POST["segment_choice"])
    && isset($_POST["state_choice"])) {
    $category_choice = $_POST["category_choice"];
    $segment_choice = $_POST["segment_choice"];
    $state_choice = $_POST["state_choice"];
}
$data = all_queries($category_choice, $segment_choice, $state_choice);
$sales_total = salesTotal($category_choice, $segment_choice, $state_choice);
$profit_total = profitTotal($category_choice, $segment_choice, $state_choice);
?>
<div class="row">
    <div class="column left">
        <h2>Totals </h2>
        <h5><?php echo $category_choice == "all"?"All Categories":$category_choice; ?></h5>
        <h5><?php echo $segment_choice== "all"?"All Segments":$segment_choice; ?> </h5>
        <h5><?php echo $state_choice== "all"?"All States":$state_choice; ?> </h5>
        <hr class="line">

        <h3>Sales Total</h3>
        <h4>$<?php echo number_format($sales_total,2); ?></h4>
        <hr class="line">

        <h3>Profit Total</h3>
        <h4>$<?php echo number_format($profit_total,2); ?></h4>
        <hr class="line">

        <h3>Profit Ratio</h3>
        <h4><?php $profit_ratio = (floatval($profit_total) / floatval($sales_total));
			echo number_format($profit_ratio * 100,2);  ?>%<h5>
    </div>
    <div class="column middle">
        <h2> The Category: <?php echo $category_choice . ' - ' . $segment_choice; ?> </h2>
        <table width="100%">
            <tr>
                <th>State</th>
                <th>Order ID</th>
                <th>Sales: USD</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Profit: USD</th>
            </tr>
            <!-- display data from query -->

                <?php $current_state = "";
					 foreach($data as $query_table){
						    if ($current_state !=$query_table['State']){
                                $current_state =$query_table['State'];?>
                                <tr><td colspan="6" style="background-color: lightgrey;"><?php echo $current_state; ?></td><tr>
                            <?php } ?>
									<tr> 
											<td> &nbsp; </td>
											<td> <?php echo $query_table['Order_ID'];   ?></td>
											<td><?php  echo number_format($query_table['Sales'],2);?></td>
											<td><?php  echo $query_table['Quantity'];   ?></td>
											<td><?php  echo floatval($query_table['Discount'])*100;  ?>%</td>
											<td><?php  echo number_format($query_table['Profit'],2);    ?></td>
													
									</tr>
								
						 	<?php } ?>
        </table>
    </div>

    <div class="column right">
        <form action="" method="post">
            <h2>Categories</h2>
            <select name='category_choice'>
                <option value="all">all</option>
                <?php
                $categories = all_categories();
                foreach ($categories as $category) { ?>
                    <option value="<?php echo $category["category"]; ?>"><?php echo $category["category"]; ?></option>
                <?php } ?>
            </select>
            <br><br>

            <h2>Segments</h2>
            <select name='segment_choice'>
                <option value="all">all</option>
                <?php
                $segments = all_segments();
                foreach ($segments as $segment) { ?>
                    <option value="<?php echo $segment["segment"]; ?>"><?php echo $segment["segment"]; ?></option>
                <?php } ?>
            </select>
            <br><br>

            <h2>States</h2>
            <select name='state_choice'>
                <option value="all">all</option>
                <?php
                $states = all_states();
                foreach ($states as $state) { ?>
                    <option value="<?php echo $state["state"]; ?>"><?php echo $state["state"]; ?></option>
                <?php } ?>
            </select>
            <br><br>
            <input type='submit' name='submit' value='Submit'>
            <br><br>
        </form>
    </div>
    </main>
    </body>
    </html>
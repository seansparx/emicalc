<?php
$amount = $_POST['amount'];
$rate = $_POST['rate'] / 12 / 100; // Monthly interest rate
$term = $_POST['term']; // Term in months

$emi = $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1));

echo "You have to pay ".number_format($emi,2)." for ".$term." months.<br/>";
echo "Total payble amount is : ".number_format($emi * $term);
echo '<br/><br/><br/>';

?>

<html>
	<body>
		<form action="" method="post">
			Amount : <input type="text" name="amount" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : ''; ?>"/><br/>
			Rate % : <input type="text" name="rate" value="<?php echo isset($_POST['rate']) ? $_POST['rate'] : ''; ?>"/><br/>
			Term in month : <input type="text" name="term" value="<?php echo isset($_POST['term']) ? $_POST['term'] : ''; ?>"/><br/>
			<input type="submit" value="Calculate"/>
		</form>
		<table width="50%">
			<thead>
				<tr><td>Year</td><td>Principal Amt</td><td>Interest Amt</td><td>Total Payment</td><td>Balance</td></tr>
			</thead>
			<tbody>
				<?php
					$balance = $amount;
					
					for($y=0; $y<$term; $y++) {
						$P1 = $emi / ($rate * (pow(1+$rate, $term-$y) / (pow(1+$rate, $term-$y) -1)));
						$P2 = $emi / ($rate * (pow(1+$rate, $term-($y+1)) / (pow(1+$rate, $term-($y+1)) -1)));
						//echo "Principle of EMI ".($y+1)." = ".round($P1 - $P2);
						
						//echo "Interest of EMI ".($y+1)." = ".round($emi - ($P1 - $P2));
						$month = date("M Y", strtotime("+".$y." month"));
						$p = ($P1 - $P2);
						$i = ($emi - $p);
						$balance -= $p;
						echo '<tr><td>'.$month.'</td><td>'.number_format($p).'</td><td>'.number_format($i).'</td><td>'.number_format($p + $i).'</td><td>'.number_format($balance).'</td></tr>';
					}
				?>
			</tbody>
		</table>
	</body>
</html>

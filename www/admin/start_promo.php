<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`partner_id`) AS 'num_partner'
				FROM ".$FD->config('pref').'partner' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_partner = $row['num_partner'];

if ( $num_partner  > 0 ) {
	$index = $FD->sql()->conn()->query ( '
				SELECT `partner_name`
				FROM '.$FD->config('pref').'partner
				ORDER BY `partner_id` DESC
				LIMIT 0,1' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $last_partner =  ( $row['partner_name'] );
}

$index = $FD->sql()->conn()->query ( "
				SELECT COUNT(`artikel_id`) AS 'num_shop'
				FROM ".$FD->config('pref').'shop' );
$row = $index->fetch(PDO::FETCH_ASSOC);
$num_shop = $row['num_shop'];

if ( $num_shop  > 0 ) {
	$index = $FD->sql()->conn()->query ( '
				SELECT `artikel_name`
				FROM '.$FD->config('pref').'shop
				ORDER BY `artikel_id` DESC
				LIMIT 0,1'  );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $last_shop =  ( $row['artikel_name'] );
}


echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$FD->text('admin', 'informations_and_statistics').'</td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$FD->text('page', 'number_of_affiliates').':</td>
                                <td class="configthin"><b>'.$num_partner.'</b></td>
                            </tr>
';

if ( $num_partner  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'newest_affiliate').':</td>
                                <td class="configthin"><b>'.$last_partner .'</b></td>
                            </tr>
	';
}

echo '
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'number_of_products').':</td>
                                <td class="configthin"><b>'.$num_shop.'</b></td>
                            </tr>
';

if ( $num_shop  > 0 ) {
	echo '
                            <tr>
                                <td class="configthin">'.$FD->text('page', 'newest_product').':</td>
                                <td class="configthin"><b>'.$last_shop .'</b></td>
                            </tr>
	';
}

echo '
						</table>
';
?>

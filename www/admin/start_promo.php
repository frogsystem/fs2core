<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$index = mysql_query ( '
						SELECT COUNT(`partner_id`) AS \'num_partner\'
						FROM '.$FD->config('pref').'partner
', $FD->sql()->conn() );
$num_partner = mysql_result ( $index, 0, 'num_partner' );

if ( $num_partner  > 0 ) {
	$index = mysql_query ( '
							SELECT `partner_name`
							FROM '.$FD->config('pref').'partner
							ORDER BY `partner_id` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$last_partner = stripslashes ( mysql_result ( $index, 0, 'partner_name' ) );
}

$index = mysql_query ( '
						SELECT COUNT(`artikel_id`) AS \'num_shop\'
						FROM '.$FD->config('pref').'shop
', $FD->sql()->conn() );
$num_shop = mysql_result ( $index, 0, 'num_shop' );

if ( $num_shop  > 0 ) {
	$index = mysql_query ( '
							SELECT `artikel_name`
							FROM '.$FD->config('pref').'shop
							ORDER BY `artikel_id` DESC
							LIMIT 0,1
	', $FD->sql()->conn() );
	$last_shop = stripslashes ( mysql_result ( $index, 0, 'artikel_name' ) );
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

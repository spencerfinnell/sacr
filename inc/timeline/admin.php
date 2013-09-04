<?php
/**
 *
 */

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_timeline_add_meta_box() {
	add_meta_box( 'timeline-date', __( 'Date', 'sacr' ), '_sacr_timeline_meta_box_date', 'time_period', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sacr_timeline_add_meta_box' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_timeline_meta_box_date() {
	global $post, $wp_locale;

	$date = sacr_item_meta( 'date' );
	$_date = sacr_item_meta( '_date' );

	$mm = mysql2date( 'n', $_date, false );
	$jj = mysql2date( 'j', $_date, false );
?>
	<style>#end-jj, #end-hh, #end-mn { width: 2em; }</style>

	<p>
		<select id="end-mm" name="end-mm">
			<?php for ( $i = 1; $i < 13; $i = $i + 1 ) : $monthnum = zeroise($i, 2); ?>
				<option value="<?php echo $monthnum; ?>" <?php selected( $monthnum, zeroise( $mm, 2 ) ); ?>>
				<?php printf( __( '%1$s' ), $wp_locale->get_month( $i ) ); ?>
				</option>
			<?php endfor; ?>
		</select>

		<input type="text" id="end-jj" name="end-jj" value="<?php echo zeroise($jj, 2); ?>" size="2" maxlength="2" autocomplete="off" />
		
		<input type="hidden" id="_date" name="_date" />
	</p>
<?php
}

function sacr_item_meta__date( $value, $post, $postdata ) {
	$year = sacr_item_year( 'time_period-year' );

	$mm = $_POST[ 'end-mm' ];
	$jj = $_POST[ 'end-jj' ];

	$aa = $year;
	$mm = ($mm <= 0 ) ? date('n') : $mm;
	$jj = ($jj <= 0 ) ? date('j') : $jj;

	$hh = 0;
	$mn = 0;
	$ss = 0;

	$date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $aa, $mm, $jj, $hh, $mn, $ss );
	$date = get_gmt_from_date( $date );

	return $date;
}
add_filter( 'sacr_item_meta__date', 'sacr_item_meta__date', 10, 3 );
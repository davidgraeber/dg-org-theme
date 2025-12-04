<?php
/**
 * Template part for displaying calendar
 *
 * @package Whatever
 *
 *
 * @var $args array
 */

$a = wtvr_localize_args( $args, [
  'cols',
  'events'
] );



?>

<section class="calendar">
    <div class="calendar-slider" data-show="<?php echo $a['cols'] ?>">
        <div class="slides with-preloader">

			<?php

			// TODAY
			$today_str   = date( 'Y/n/d' );
			$today_arr   = array_combine( [ 'year', 'month', 'day' ], explode( '/', $today_str ) );
			$today_index = $today_arr['day'] - 1;

			// Format helper
			$date_keys = [
			  'year'  => 'Y',
			  'full'  => 'F',
			  'short' => 'M',
			  'n'     => 'n',
			  'days'  => 't',
			];

			// Week days list
			$week_days_str = __( 'M-T-W-T-F-S-S', 'wtvr' );
			$week_days_arr = explode( '-', $week_days_str );

			// Construct weekdays header todo: outsource
			$week_days_header_html = '<div class="weekdays grid-month">';
			foreach ( $week_days_arr as $week_day ) {
				$week_days_header_html .= '<div class="weekday">' . $week_day . '</div>';
			}
			$week_days_header_html .= '</div>';

			// Flip date format keys to combine with each month's date
			$date_keys_flipped = array_flip( $date_keys );

			$date_format = join( '-', $date_keys );


			// Define months to show
			$m_to_show = 4;
			// Get upcoming months
			$cal_months = [];
			for ( $i = 0; $i < $m_to_show; $i ++ ) {

				$date_offset = strtotime( '+' . $i . ' month' ); // 1 month offset
				$date_str    = date( $date_format, $date_offset ); // Y-m-etc...
				$date_arr    = explode( '-', $date_str );

				$year_month = $date_arr['0'] . '-' . $date_arr['3'];

				$cal_months[ $year_month ] = array_combine( $date_keys_flipped, $date_arr );

				$firstday                                   = date( 'Y-m-01', $date_offset );
				$cal_months[ $year_month ]['first-weekday'] = date( 'w', strtotime( $firstday ) );
			}

			// if there are events for current year
			foreach ( $a['events'] as $month => $days ) :
				$cal_months[ $month ]['event-days'] = $days;
			endforeach;


			$m = 0; // month column counter, not actual month number
			foreach ( $cal_months as $cal_month ) :
				$m ++;
				$is_current_month = $cal_month['year'] === $today_arr['year'] && $cal_month['n'] === $today_arr['month'];

				?>

                <div class="slide month">
					<?php
					// Add links to the start and end of the calendar
					if ( 1 === $m ) : ?>
                        <div class="pre-events hide-at-768">
                            <p>
                                <a href="/events-archive/">Past events</a>
                            </p>
                        </div>
					<?php elseif ( $m_to_show === $m ): ?>
                        <div class="post-events">
                            <p>
                                <a class="go-first-slide" href="#">← today</a>
                            </p>
                        </div>
					<?php endif; ?>


                    <h3><?php echo $cal_month['full'] . ' ' . $cal_month['year']; ?></h3>

					<?php
					// WEEK DAYS HEADER
					echo $week_days_header_html;

					$cal_days = array_map( function ( $day ) use ( $cal_month ) {
						return [
						  'd' => $day,
						  'events' => false,
						];
					}, range( 1, $cal_month['days'] ) );

					if ( isset($cal_month['event-days'] ) ){

						foreach ( $cal_month['event-days'] as $event_day => $events ) :
							$cal_days[ $event_day - 1 ]['events'] = $events;
						endforeach;

                    }

					?>
                    <div class="days grid-month">
						<?
						foreach ( $cal_days as $cal_day ) {

							echo wtvr_cal_day(
							  $cal_month,
							  $cal_day['d'],
							  wtvr_cal_class( $cal_day, $is_current_month, $today_arr['day'] ),
							  $cal_day['events']
							);

						}
						?>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>

    <div class="dayview">


        <p class="notice select-day">Select a day to view events<span class="show-at-768">,
                <br>slide ← & → between months</span>.
        </p>

        <p class="notice hidden no-events">No events on the selected day.</p>

		<?php foreach ( $a['events'] as $month => $days ) :
			$year_month = explode( '-', $month );
			foreach ( $days as $day => $events ) :
				if ( empty( $day ) ) : ?>
                    <h3>No events on <?php echo $day . '.' . $year_month[1] . '.' . $year_month[0] . ':'; ?></h3>
				<?php else: ?>
                    <div class="agenda" id="agenda-<?php echo $year_month[0] . '-' . $year_month[1] . '-' . intval($day); ?>">
                        <p class="notice">Events
                            on <?php echo $day . '.' . $year_month[1] . '.' . $year_month[0] . ':'; ?></p>

						<?php foreach ( $events as $id => $event ) : ?>

                            <div class="event">
								<?php get_template_part( 'template-parts/content', 'card-event', [
								  'id' => $id,
								] ) ?>
                            </div>
						<?php endforeach; ?>
                    </div>
				<?php endif;
			endforeach;
		endforeach; ?>

    </div>

</section>


<style>body {background:#120c36;color:fff;}svg{margin-top:5em;}h1,h2,h3{color:#fff}</style>
<div style="background-color:#120c36; color:#fff; padding:5em; margin: 5em auto; width:50%; text-align:left;">
	<h1>
		<?php esc_html_e( 'TBD Events - Details', 'tbd-events' ); ?>
	</h1>
	<div>
		<h2><?php esc_html_e( 'Shortcodes', 'tbd-events'); ?></h2>
		<p>
			<?php esc_html_e( 'There are two shortcodes you can use with TBD Events: [events_calendar] and [events_list].', 'tbd-events'); ?>
		</p>
		<div style="border:1px solid #fff;margin:2em 0;padding:1em;">
			<h2><?php esc_html_e( '[events_calendar]', 'tbd-events'); ?></h2>
			<p>
				<?php esc_html_e( 'This shortcode will display a calendar that fills the container it is placed in. You can use the following shortcode attributes:', 'tbd-events'); ?>
			</p>
			<ul style="list-style:disc;padding-left:1.5em">
				<li><?php esc_html_e( 'cat="a-category-slug" - Use a comma-separated list of category slugs to show these events in the calendar.', 'tbd-events') ?></li>
				<li><?php esc_html_e( 'days_ago="7" - The number of days to display into the past.', 'tbd-events') ?></li>
			</ul>
		</div>
		<div style="border:1px solid #fff;margin:2em 0;padding:1em;">
			<h2><?php esc_html_e( '[events_list]', 'tbd-events'); ?></h2>
			<p>
				<?php esc_html_e( 'This shortcode will display a list with the event title, the event date, and a link to the product page. You can use the following shortcode attributes:', 'tbd-events'); ?>
			</p>
			<ul style="list-style:disc;padding-left:1.5em">
				<li><?php esc_html_e( 'cat="a-category-slug" - Use a comma-separated list of category slugs to show these events in the calendar.', 'tbd-events') ?></li>
				<li><?php esc_html_e( 'limit="6" - The number of events to display in the list.', 'tbd-events') ?></li>
				<li><?php esc_html_e( 'button="Book Now" - The text to show on the link to the product page.', 'tbd-events') ?></li>
			</ul>
		</div>
		<h2><?php esc_html_e( 'Styling the shortcode output', 'tbd-events'); ?></h2>
		<p>
			<?php esc_html_e( 'The elements can be styled by applying CSS rules in the Customise menu for the different elements. Alternatively, if you are using Elementor, you can use the Elementor Widgets and style them as you would any other Elementor widget.', 'tbd-events'); ?>
		</p>
		<h2><?php esc_html_e( 'Adding new events', 'tbd-events'); ?></h2>
		<p>
			<?php esc_html_e( 'To set up an event, Add a new product, and change the type to "Event". On the Event Details tab, you can add the date/s of the event, the host, and fill out the rest as you would any other product. On the Hosts tab of the TBD Events menu, you can customise the Host\'s information, which will be shown on the product page.', 'tbd-events'); ?>
		</p>
		
		
		<svg id="logo" class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 760.27 191.18"><g data-name="Layer 2"><path d="M312.35 133.92a8 8 0 00-4.28-1.11h-3.51V150h3.51a7.92 7.92 0 004.28-1.13 7.47 7.47 0 002.79-3.05 9.49 9.49 0 001-4.39 9.69 9.69 0 00-1-4.48 7.29 7.29 0 00-2.79-3.03zM304.91 0h-36.66v60.13h-57.53V0h-36.31v82h130.5zm149 60.18L468.39 82h41.4L455.48 0h-37.9v82h36.31zM379.68 0h-36.31v82h36.31zm170.78 0h-36.31v82h36.31zm108.88 68.81L726.91 0h-49.58l-52 54.58V0h-36.51v82h81.8zm-526.49 68.64a2.65 2.65 0 00.88-2.07 2.84 2.84 0 00-.87-2.09 4.07 4.07 0 00-2.94-.86h-5.65v5.82h5.6a4.43 4.43 0 002.98-.8zm-2.79 7.21h-5.79v5.61h5.79a4.75 4.75 0 002.79-.69 2.34 2.34 0 001-2 2.69 2.69 0 00-.9-2.12 4.19 4.19 0 00-2.89-.8zM73.3 82h36.32V31.49H154V0H28.6v31.49h44.7zM0 100.28v90.9h760.27v-90.9zm141.18 50.58a7.62 7.62 0 01-1.75 2.81 9.1 9.1 0 01-3.47 2.14 16.59 16.59 0 01-5.68.83H117v-30.51h13.18a15.13 15.13 0 016.13 1.08 8.19 8.19 0 013.64 2.93 7.51 7.51 0 011.22 4.2 6.46 6.46 0 01-1.45 4.27 8.18 8.18 0 01-3.77 2.55 9.79 9.79 0 012.86 1.25 6.36 6.36 0 012.07 2.21 6.81 6.81 0 01.79 3.4 9.05 9.05 0 01-.49 2.84zm56.51-6.86v12.66h-7.22V144l-10.08-17.85h8.54l5.28 10.32 5.63-10.32h8.51zM322 149.51a13.73 13.73 0 01-5.61 5.28 17.86 17.86 0 01-8.29 1.85h-10.81v-30.51h10.78a17.74 17.74 0 018.29 1.86 13.82 13.82 0 015.61 5.29 15.63 15.63 0 012 8.15 15.47 15.47 0 01-1.97 8.08zm64.38-17.08h-13.1v5.86h12.28v6.32h-12.31v5.66h13.1v6.37H366v-30.51h20.36zm66.21 20.81a8.78 8.78 0 01-4.24 3.09 19.39 19.39 0 01-6.73 1 16.25 16.25 0 01-6.06-1.11 10.18 10.18 0 01-4.54-3.45 10.89 10.89 0 01-1.93-6.13h7.17a3.65 3.65 0 00.71 2.3 4.12 4.12 0 001.91 1.34 8 8 0 002.69.43 12 12 0 002.22-.2 3.73 3.73 0 001.66-.73 1.75 1.75 0 00.64-1.43 2 2 0 00-.67-1.66 9.92 9.92 0 00-2.42-1.25l-6.62-2.89a15.33 15.33 0 01-5.09-3.32 7.25 7.25 0 01-1.81-5.21 7.46 7.46 0 013.14-6.24q3.15-2.37 8.61-2.37c3.71 0 6.55.87 8.54 2.62a10.58 10.58 0 013.33 7.49H446a4.62 4.62 0 00-1.33-2.52 4.79 4.79 0 00-3.42-1 5.34 5.34 0 00-2.74.62 1.82 1.82 0 00-1 1.56 1.61 1.61 0 00.67 1.36 10.86 10.86 0 002 1.1l7 3a14 14 0 015.21 3.57 7.43 7.43 0 011.72 4.91 8.59 8.59 0 01-1.55 5.12zm51.64 3.4h-7.26v-30.51h7.26zm69.2 0h-6l-.66-4.59a8.75 8.75 0 01-2.52 3.84 6.77 6.77 0 01-4.47 1.48 12 12 0 01-6.86-2.05 14.09 14.09 0 01-4.79-5.65 18.55 18.55 0 01-1.76-8.29 19.16 19.16 0 011-6.44 14.82 14.82 0 013-5.05 13.23 13.23 0 014.59-3.28 14.56 14.56 0 015.93-1.16 13.44 13.44 0 018.06 2.24 12.25 12.25 0 014.42 7l-7.71 1.39a7.71 7.71 0 00-2-3 4.61 4.61 0 00-3.13-1.09 5 5 0 00-3.19 1.13 7.58 7.58 0 00-2.23 3.23 15.62 15.62 0 000 10 7.43 7.43 0 002.23 3.24 5 5 0 003.19 1.14 6.48 6.48 0 003.12-.74 5.56 5.56 0 002.16-2 5.19 5.19 0 00.78-2.78V145h-6.06v-4.46h13zm69.88 0h-7L624 138.17v18.47h-7.3v-30.51h7.58L636 143.84v-17.71h7.26z" fill="#fff" fill-rule="evenodd" data-name="BY DESIGN"></path></g></svg>
	</div>

</div>
	var calendarEl = document.getElementsByClassName('tbd-calendar');
	for (let div of calendarEl) {
		var calendar = new FullCalendar.Calendar(div, {
			initialView: 'dayGridMonth',
			expandRows: 'true',
			aspectRatio:1.36,
			eventDisplay: 'list-item'
		});
		calendar.render();
	}
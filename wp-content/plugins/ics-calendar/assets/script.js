jQuery(function() {

	// View: ALL
	jQuery('.ics-calendar.toggle .event').on('click', function() {
		if (jQuery(this).hasClass('open')) { jQuery(this).removeClass('open'); }
		else { jQuery(this).addClass('open'); }
	});

	// View: currentweek
	if (jQuery('.ics-calendar-currentweek-wrapper').length > 0) {
		jQuery('.ics-calendar-month-grid tbody tr').addClass('remove');
		jQuery('.ics-calendar-month-grid tbody td.today').parent().addClass('current-week').removeClass('remove');
		jQuery('.ics-calendar-month-grid tbody td.today').parent().prev().addClass('previous-week').removeClass('remove');
		jQuery('.ics-calendar-month-grid tbody td.today').parent().next().addClass('next-week').removeClass('remove');
		jQuery('.ics-calendar-month-grid tbody tr.remove').remove();
		jQuery('.ics-calendar-month-grid tbody tr.current-week').show();
		jQuery('.ics-calendar-select').show();
		jQuery('.ics-calendar-currentweek-wrapper:first-of-type').show();
		jQuery('.ics-calendar-select').on('change', function() {
			jQuery('.ics-calendar-month-grid tbody tr').hide();
			jQuery('.ics-calendar-month-grid tbody tr.' + jQuery(this).val()).show();
		});
	}

	// View: list
	if (jQuery('.ics-calendar-list-wrapper').length > 0) {
	}
	
	// View: month
	if (jQuery('.ics-calendar-month-wrapper').length > 0) {
		jQuery('.ics-calendar-select').show();
		jQuery('.ics-calendar-month-wrapper:first-of-type').show();
		jQuery('.ics-calendar-select').on('change', function() {
			jQuery('.ics-calendar-month-wrapper').hide();
			jQuery('.ics-calendar-month-wrapper[data-year-month="' + jQuery(this).val() + '"]').show();
		});
	}

});

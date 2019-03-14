(function($) {

	$(document).ready(function() {

		const elems = document.querySelectorAll('.wpd-block-notice.wpd-dismissable[data-id]');
		elems.forEach(el => {
			const uid = el.getAttribute( 'data-id' );
			if ( ! localStorage.getItem(`notice-${uid}`) ) {
				el.style.display = 'block';
			}

			if ( $( '.wpd-notice-dismiss' ).length ) {
				el.querySelector('.wpd-notice-dismiss').addEventListener('click', () => {
					localStorage.setItem(`notice-${uid}`, 1);
					el.style.display = '';
				})
			}
		})

	});

})(jQuery);

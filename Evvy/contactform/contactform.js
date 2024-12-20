$(document).ready(function() {
	$('#contactform').on('submit', function (e) {
		e.preventDefault(); // Prevent default form submission
	
		const form = $(this);
		const responseElement = $('#form-response');
		$("#contactform_btn").html('Please wait... <span class="fas fa-circle-notch fa-spin"></span>');
	
		$.ajax({
		  url: form.attr('action'),
		  type: 'POST',
		  data: form.serialize(),
		  cache: false,
		  dataType: 'json',
		  success: function (data) {
			if (data.status === 'OK') {
			  responseElement.css('color', 'green').text('Your message has been sent successfully!');
			  form[0].reset(); // Reset the form
			} else {
			  responseElement.css('color', 'red').text('Something went wrong. Please try again.');
			}
			$("#contactform_btn").html('Send Message <span class="fa-solid fa-angle-right"></span>');
		  },
		  error: function () {
			responseElement.css('color', 'red').text('Error: Unable to send your message.');
			$("#contactform_btn").html('Send Message <span class="fa-solid fa-angle-right"></span>');
		  },
		});
	  });
});
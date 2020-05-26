<?php
//Helper functions. Likely place in external file
function _e( $string ) {
	return htmlentities($string,ENT_QUOTES,'UTF-8',false);
}

/* ------------------------------------------------------------------
   STUFF YOU NEED TO CHANGE FOR YOUR SPECIFIC FORM
--------------------------------------------------------------------*/

// Specify the form field names your form will accept
$whitelist = array( 'name', 'email', 'message');

// Set the email address submissions will be sent to
$email_address = 'marek@mdnilson.com';

// Set the subject line for email messages
$subject = 'New Contact Form Submission';

/* ------------------------------------------------------------------
   END STUFF YOU NEED TO CHANGE FOR YOUR SPECIFIC FORM
--------------------------------------------------------------------*/

// Instantiate variables we'll use
$errors = array();
$fields = array();

// Check for form submission
if ( ! empty( $_POST ) ) {

	// Validate math
	if ( intval( $_POST['human'] ) !== 7 ) {
		$errors[] = 'Your math is suspect.';
	}

	// Validate email address
	if ( ! empty( $_POST['email'] ) && ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
		$errors[] = 'That is not a valid email address';
	}

	// Perform field whitelisting
	foreach ( $whitelist as $key ) {
		$fields[$key] = $_POST[$key];
	}

	// Validate field data
	foreach ( $fields as $field => $data ) {
		if ( empty( $data ) ) {
			$errors[] = 'Please enter your ' . $field;
		}
	}

	// Check and process
	if ( empty( $errors ) ) {
		$sent = mail( $email_address, $subject, $fields['message'] );
	}
}
?>



<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>mdnilson - kontakt</title>

    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- My styles -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <section class="section" id="contact-form">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Enter your message below</h1>
					<?php if ( ! empty( $errors ) ) : ?>
					<div class="errors">
                        <p class="bg-danger"><?php echo implode( '</p><p class="bg-danger">', $errors ); ?></p>
					</div>
					<?php elseif ( $sent ) : ?>
					<div class="success">
						<p class="bg-success">Your message was sent. We'll be in touch.</p>
					</div>
					<?php endif; ?>
					<form role="form" method="post" action="contact.php">
						<div class="form-group">
							<label for="name" class="control-label">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="e.g. John Doe"
								   value="<?php echo isset( $fields['name'] ) ? _e( $fields['name'] ) : '' ?>">
						</div>
						<div class="form-group">
							<label for="email" class="control-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="e.g. example@domain.com"
								  value="<?php echo isset( $fields['email'] ) ? _e( $fields['email'] ) : '' ?>">
						</div>
						<div class="form-group">
							<label for="message" class="control-label">Message</label>
							<textarea class="form-control" rows="4" name="message"><?php echo isset( $fields['message'] ) ? _e( $fields['message'] ) : '' ?></textarea>
						</div>
						<div class="form-group">
							<label for="human" class="control-label">5 + 2 = ?</label>
							<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
						</div>
						<div class="form-group">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

    <!-- Footer -->
    <footer>
        <div>&copy;mdnilson, 2020</div>
    </footer>
    </div>

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>

</html>
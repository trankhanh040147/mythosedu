<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>PDF Certificate Title</title>
	<style type="text/css"><?php $this->pdf_style(); ?></style>
</head>
<body>

<div class="certificate-wrap">

	<table>
		<tr>
			<td class="first-col">
				<div class="certificate-content">
					<br/>
					<br/>
					<br/>
					<br/>
					<p><?php esc_html_e( 'This is to certify that', 'tutor-pro' ); ?></p>
					<h1><?php echo esc_html( tutor_utils()->get_user_name( $user ) ); ?></h1>
					<br/>
					<br/>
					<p><?php echo esc_html__( 'has successfully completed', 'tutor-pro' ) . ' ' . esc_html( $duration_text ) . ' ' . esc_html__( 'online course of', 'tutor-pro' ); ?></p>
					<h2><?php echo esc_html( $course->post_title ); ?></h2>
					<p><?php echo esc_html__( 'on', 'tutor-pro' ) . ' ' . esc_html( $completed_date ); ?></p>
				</div>
			</td>
			<td>
				<div class="verifying-wrap">
					<p><strong><?php esc_html_e( 'Valid Certificate ID', 'tutor-pro' ); ?></strong></p>
					<p><?php echo esc_html( $completed->completed_hash ); ?></p>
				</div>
				<div class="signature-wrap">
					<img src="<?php echo esc_url( $signature_image_url ); ?>" />
					<p class="certificate-author-name"> <strong><?php echo esc_html( tutor_utils()->get_option( 'tutor_cert_authorised_name' ) ); ?></strong> </p>
					<?php echo esc_html( tutor_utils()->get_option( 'tutor_cert_authorised_company_name' ) ); ?>
				</div>
			</td>
		</tr>
	</table>
</div>

<div id="watermark">
	<img src="<?php echo esc_url( $this->template['url'] . 'background.png' ); ?>" height="100%" width="100%" />
</div>

</body>
</html>

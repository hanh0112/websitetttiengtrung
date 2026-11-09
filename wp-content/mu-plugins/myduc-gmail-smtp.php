<?php

add_action( 'phpmailer_init', 'myduc_configure_gmail_smtp' );
add_action( 'wp_mail_failed', 'myduc_log_mail_failure' );

function myduc_configure_gmail_smtp( $mailer ) {
    $host = trim( (string) getenv( 'MYDUC_SMTP_HOST' ) );
    $port = filter_var( getenv( 'MYDUC_SMTP_PORT' ), FILTER_VALIDATE_INT );
    $secure = strtolower( trim( (string) getenv( 'MYDUC_SMTP_SECURE' ) ) );
    $username = trim( (string) getenv( 'MYDUC_SMTP_USERNAME' ) );
    $password = preg_replace( '/\s+/', '', (string) getenv( 'MYDUC_SMTP_APP_PASSWORD' ) );

    if (
        '' === $host
        || false === $port
        || $port < 1
        || ! in_array( $secure, array( 'tls', 'ssl' ), true )
        || ! is_email( $username )
        || '' === $password
    ) {
        error_log( '[MyDuc SMTP] Gmail SMTP settings are missing or invalid; email delivery is unavailable.' );
        return;
    }

    $mailer->isSMTP();
    $mailer->Host = $host;
    $mailer->Port = $port;
    $mailer->SMTPAuth = true;
    $mailer->Username = $username;
    $mailer->Password = $password;
    $mailer->SMTPSecure = $secure;
    $mailer->SMTPAutoTLS = 'tls' === $secure;
    $mailer->SMTPDebug = 0;
    if ( ! $mailer->setFrom(
        $username,
        wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
        false
    ) ) {
        error_log( '[MyDuc SMTP] The authenticated Gmail address could not be used as the sender.' );
    }
}

function myduc_log_mail_failure( $error ) {
    if ( is_wp_error( $error ) ) {
        error_log(
            sprintf(
                '[MyDuc SMTP] WordPress mail failed (%s): %s',
                sanitize_key( $error->get_error_code() ),
                sanitize_text_field( $error->get_error_message() )
            )
        );
    }
}

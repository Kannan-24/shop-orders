@extends('emails.simple-layout')

@section('title', 'Reset Password')

@section('content')
<h2>Reset Your Password</h2>

<p>Hello,</p>

<p>You are receiving this email because we received a password reset request for your account.</p>

<div class="info-box">
    <p>Click the button below to reset your password. This link will expire in 60 minutes.</p>
</div>

<a href="{{ $url }}" class="btn">Reset Password</a>

<p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>

<p style="word-break: break-all; color: #666;">{{ $url }}</p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Thank you for using {{ config('app.name') }}!</p>
@endsection

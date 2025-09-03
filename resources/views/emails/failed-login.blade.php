@extends('emails.simple-layout')

@section('title', 'Failed Login Attempt')

@section('content')
<h2>Failed Login Attempt Detected</h2>

<p>Hello {{ $user->name }},</p>

<p>We've detected a failed login attempt to your account. Here are the details:</p>

<div class="alert-box">
    <dl class="detail-list">
        <dt>Attempt Time:</dt>
        <dd>{{ $attemptTime }}</dd>
        
        <dt>Device:</dt>
        <dd>{{ $device }}</dd>
        
        <dt>IP Address:</dt>
        <dd>{{ $ipAddress }}</dd>
        
        <dt>Location:</dt>
        <dd>{{ $location ?? 'Unknown' }}</dd>
    </dl>
</div>

<p>If this was you, please check your login credentials. If this wasn't you, please take the following actions:</p>

<ul>
    <li>Change your password immediately</li>
    <li>Enable two-factor authentication if available</li>
    <li>Review your account for any suspicious activity</li>
    <li>Contact our support team if you need assistance</li>
</ul>

<p>Your account security is our priority. Please contact us if you have any concerns.</p>

<p>Thank you for using {{ config('app.name') }}!</p>
@endsection

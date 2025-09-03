@extends('emails.simple-layout')

@section('title', 'Login Notification')

@section('content')
<h2>New Login Detected</h2>

<p>Hello {{ $user->name }},</p>

<p>We've detected a new login to your account with the following details:</p>

<div class="info-box">
    <dl class="detail-list">
        <dt>Login Time:</dt>
        <dd>{{ $loginTime }}</dd>
        
        <dt>Device:</dt>
        <dd>{{ $device }}</dd>
        
        <dt>IP Address:</dt>
        <dd>{{ $ipAddress }}</dd>
        
        <dt>Location:</dt>
        <dd>{{ $location ?? 'Unknown' }}</dd>
    </dl>
</div>

<p>If this was you, no further action is required. If you didn't log in, please secure your account immediately by:</p>

<ul>
    <li>Changing your password</li>
    <li>Enabling two-factor authentication</li>
    <li>Reviewing your account activity</li>
</ul>

<p>Thank you for using {{ config('app.name') }}!</p>
@endsection

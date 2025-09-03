@extends('emails.simple-layout')

@section('title', 'Password Expiry Reminder')

@section('content')
<h2>Password Expiry Reminder</h2>

<p>Hello {{ $user->name }},</p>

<p>This is a reminder that your password will expire soon and needs to be changed.</p>

<div class="warning-box">
    <dl class="detail-list">
        <dt>Current Password Age:</dt>
        <dd>{{ $daysOld }} days</dd>
        
        <dt>Days Until Expiry:</dt>
        <dd>{{ $daysUntilExpiry }} days</dd>
        
        <dt>Last Password Change:</dt>
        <dd>{{ $lastChanged ?? 'Never' }}</dd>
    </dl>
</div>

<p>For your account security, we require passwords to be changed regularly. Please log in to your account and update your password.</p>

<p>If you don't change your password before it expires, you may need to reset it to regain access to your account.</p>

<a href="{{ config('app.url') }}/profile" class="btn">Change Password Now</a>

<p>Thank you for using {{ config('app.name') }}!</p>
@endsection

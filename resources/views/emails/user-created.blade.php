@extends('emails.simple-layout')

@section('title', 'Welcome to {{ config("app.name") }}')

@section('content')
<h2>Welcome to {{ config('app.name') }}!</h2>

<p>Hello {{ $user->name }},</p>

<p>Your account has been successfully created. Here are your account details:</p>

<div class="info-box">
    <dl class="detail-list">
        <dt>Name:</dt>
        <dd>{{ $user->name }}</dd>
        
        <dt>Email:</dt>
        <dd>{{ $user->email }}</dd>
        
        <dt>Account Created:</dt>
        <dd>{{ $user->created_at->format('F j, Y g:i A') }}</dd>
    </dl>
</div>

<p>You can now log in to your account and start using our services.</p>

<p>If you have any questions or need help getting started, please don't hesitate to contact our support team.</p>

<p>Thank you for joining {{ config('app.name') }}!</p>
@endsection

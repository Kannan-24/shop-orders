@extends('emails.simple-layout')

@section('title', 'Password Successfully Changed')

@section('content')
    <p><strong>Your password has been successfully changed</strong></p>

    <p>Your {{ config('app.name') }} account password was updated on <strong>{{ $timestamp }}</strong>.</p>

    <table class="info-table">
        <tr>
            <td><strong>Device</strong></td>
            <td>{{ $deviceInfo['device'] ?? 'Unknown Device' }}</td>
        </tr>
        <tr>
            <td><strong>Operating System</strong></td>
            <td>{{ $deviceInfo['os'] ?? 'Unknown OS' }}</td>
        </tr>
        <tr>
            <td><strong>Browser</strong></td>
            <td>{{ $deviceInfo['browser'] ?? 'Unknown Browser' }}</td>
        </tr>
        <tr>
            <td><strong>IP Address</strong></td>
            <td>{{ $ipAddress ?? 'Unknown' }}</td>
        </tr>
    </table>

    <p><strong>What this means:</strong></p>
    <ul>
        <li>Your account security has been strengthened</li>
        <li>All previous sessions have been invalidated</li>
        <li>You can continue using your account normally</li>
    </ul>

    <p>If you made this change, no further action is required.</p>

    <p><strong>Didn't change your password?</strong></p>
    <p>If you did NOT make this change, your account may have been compromised. Please:</p>
    <ul>
        <li><a href="{{ $resetUrl }}">Reset your password immediately</a></li>
        <li>Contact our support team at <a
                href="mailto:support@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com">support@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com</a></li>
    </ul>
@endsection

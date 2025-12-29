@extends('web.customer.layouts.app')

@section('header_title', 'Profil Saya')
@section('header_subtitle', 'Beritahu kami lebih banyak tentang diri Anda.')

@section('customer_content')
<div class="space-y-12">
    {{-- Update Profile Info --}}
    @include('web.customer.profile.partials.update-profile-information-form')

    {{-- Update Password --}}
    @include('web.customer.profile.partials.update-password-form')

    {{-- Delete Account --}}
    @include('web.customer.profile.partials.delete-user-form')
</div>
@endsection

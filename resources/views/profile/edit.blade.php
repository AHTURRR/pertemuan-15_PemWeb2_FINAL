@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <x-page-header
        title="Profile Pengguna"
        subtitle="Kelola informasi akun, password, dan preferensi keamanan."
        icon="bi-person-gear"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Profile'],
        ]"
    />

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="app-card">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        <div class="col-xl-6">
            <div class="app-card">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        <div class="col-xl-6">
            <div class="app-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

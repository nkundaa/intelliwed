@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<section class="py-6">
    <div class="container">
        <div class="card p-6 mb-6">
            <h1>Admin Dashboard</h1>
            <p>Overview of platform growth, activity, and revenue.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-4">
                <h3 class="text-sm">Total Users</h3>
                <p class="text-xl font-bold">{{ $users }}</p>
            </div>
            <div class="card p-4">
                <h3 class="text-sm">Total Vendors</h3>
                <p class="text-xl font-bold">{{ $vendors }}</p>
            </div>
            <div class="card p-4">
                <h3 class="text-sm">Total Bookings</h3>
                <p class="text-xl font-bold">{{ $bookings }}</p>
            </div>
            <div class="card p-4">
                <h3 class="text-sm">Revenue</h3>
                <p class="text-xl font-bold">${{ $revenue }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
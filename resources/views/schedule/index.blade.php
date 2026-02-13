@extends('layouts.app')

@section('content')
<div class="columns is-centered">
    <div class="column is-10">
        
        <!-- Hero Section -->
        <div class="hero is-small hero-gradient mb-5">
            <div class="hero-body">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <p class="subtitle is-6 has-text-weight-light mb-1">Selamat Datang di</p>
                            <h1 class="title is-2 mb-2">Sistem Peminjaman Lapangan</h1>
                            <p class="is-size-5 opacity-90">Cek jadwal dan booking lapangan dengan mudah.</p>
                        </div>
                    </div>
                    <div class="level-right is-hidden-mobile">
                        <span class="icon is-large">
                            <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="level mb-5">
            <div class="level-left">
                <h2 class="title is-4 has-text-white">Jadwal Terdaftar</h2>
            </div>
            <div class="level-right">
                <a href="{{ route('schedule.create') }}" class="button is-primary is-medium shadow-hover is-rounded">
                    <span class="icon">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    <span>Booking Baru</span>
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            @if(count($schedules) > 0)
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable is-striped">
                    <thead>
                        <tr>
                            <!-- Mapping: [0]Timestamp, [1]Tanggal, [2]Nama, [3]Kegiatan, [4]Mulai, [5]Selesai -->
                            <th class="has-text-grey-light">Tanggal</th>
                            <th class="has-text-grey-light">Jam</th>
                            <th class="has-text-grey-light">Nama Peminjam</th>
                            <th class="has-text-grey-light">Kegiatan</th>
                            <th class="has-text-grey-light has-text-centered">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $row)
                        <tr>
                            <td data-label="Tanggal" class="has-text-weight-medium">
                                <span class="icon-text">
                                    <span class="icon has-text-info is-small"><i class="far fa-calendar"></i></span>
                                    <span>{{ $row[1] ?? '-' }}</span>
                                </span>
                            </td>
                            <td data-label="Jam">
                                <span class="tag is-info is-light">
                                    {{ $row[4] ?? '-' }} - {{ $row[5] ?? '-' }}
                                </span>
                            </td>
                            <td data-label="Peminjam" class="has-text-weight-semibold">{{ $row[2] ?? '-' }}</td>
                            <td data-label="Kegiatan">{{ $row[3] ?? '-' }}</td>
                            <td data-label="Status" class="has-text-centered">
                                <span class="tag is-success is-light is-rounded">
                                    <span class="icon is-small"><i class="fas fa-check"></i></span>
                                    <span>Booked</span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="has-text-centered py-6">
                <div class="mb-4 has-text-grey-lighter">
                    <i class="fas fa-clipboard-list fa-4x"></i>
                </div>
                <h3 class="title is-4 has-text-grey">Belum ada jadwal</h3>
                <p class="subtitle is-6 has-text-grey-light">Jadwal masih kosong. Jadilah yang pertama booking!</p>
                <a href="{{ route('schedule.create') }}" class="button is-primary is-outlined is-rounded mt-2">
                    Booking Sekarang
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

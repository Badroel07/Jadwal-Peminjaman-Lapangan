@extends('layouts.app')

@section('content')
    <div class="columns is-centered">
        <div class="column is-6-desktop is-8-tablet">
            <div class="flat-container">
                <div class="flat-header">
                    <p class="flat-header-title">
                        <span class="icon is-medium mr-2">
                            <i class="fas fa-calendar-plus has-text-primary"></i>
                        </span>
                        Form Booking Lapangan
                    </p>
                </div>
                
                <form action="{{ route('schedule.confirm') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">Nama Peminjam</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                                placeholder="Contoh: Organisasi BEM" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        @error('nama_peminjam') <p class="help is-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="label">Nama Kegiatan</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                placeholder="Contoh: Latihan Futsal Mingguan" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-futbol"></i>
                            </span>
                        </div>
                        @error('nama_kegiatan') <p class="help is-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="columns">
                        <div class="column is-12">
                            <div class="field">
                                <label class="label">Hari/Tanggal</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="date" name="tanggal" value="{{ old('tanggal') }}"
                                        required onkeydown="return false" onclick="this.showPicker()">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                @error('tanggal') <p class="help is-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-6">
                            <div class="field">
                                <label class="label">Waktu Mulai</label>
                                <div class="control has-icons-left">
                                    <div class="select is-fullwidth">
                                        <select name="waktu_mulai" required>
                                            <option value="" disabled selected>Pilih Jam</option>
                                            @foreach(range(6, 22) as $hour)
                                                <option value="{{ sprintf('%02d:00', $hour) }}" {{ old('waktu_mulai') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $hour) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                </div>
                                @error('waktu_mulai') <p class="help is-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="column is-6">
                            <div class="field">
                                <label class="label">Waktu Berakhir</label>
                                <div class="control has-icons-left">
                                    <div class="select is-fullwidth">
                                        <select name="waktu_berakhir" required>
                                            <option value="" disabled selected>Pilih Jam</option>
                                            @foreach(range(7, 23) as $hour)
                                                <option value="{{ sprintf('%02d:00', $hour) }}" {{ old('waktu_berakhir') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $hour) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-hourglass-end"></i>
                                    </span>
                                </div>
                                @error('waktu_berakhir') <p class="help is-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="field mt-6">
                        <div class="control">
                            <button class="button is-primary is-fullwidth is-medium shadow-hover" type="submit">
                                <strong>Lanjut ke Konfirmasi</strong>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="has-text-centered mt-4">
                <a href="{{ route('schedule.index') }}" class="button is-text has-text-grey">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Kembali ke Jadwal</span>
                </a>
            </div>
        </div>
    </div>
@endsection
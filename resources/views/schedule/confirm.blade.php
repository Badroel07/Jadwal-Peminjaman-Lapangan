@extends('layouts.app')

@section('content')
    <div class="columns is-centered">
        <div class="column is-6-desktop is-8-tablet">
            <div class="flat-container">
                <div class="flat-header">
                    <p class="flat-header-title">
                        <span class="icon mr-2"><i class="fas fa-exclamation-triangle has-text-warning"></i></span>
                        Konfirmasi Booking & Ketentuan
                    </p>
                </div>

                <h3 class="title is-5 mb-4 has-text-white">Pastikan Data Booking Benar:</h3>
                <div class="box has-background-dark has-radius mb-5" style="border: 1px solid rgba(255,255,255,0.05);">
                    <div class="columns is-multiline is-mobile">
                        <div class="column is-4 has-text-grey">Nama Peminjam</div>
                        <div class="column is-8 has-text-weight-bold">{{ $data['nama_peminjam'] }}</div>

                        <div class="column is-4 has-text-grey">Kegiatan</div>
                        <div class="column is-8 has-text-weight-bold">{{ $data['nama_kegiatan'] }}</div>

                        <div class="column is-4 has-text-grey">Tanggal</div>
                        <div class="column is-8 has-text-weight-bold">
                            {{ \Carbon\Carbon::parse($data['tanggal'])->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>

                        <div class="column is-4 has-text-grey">Waktu</div>
                        <div class="column is-8 has-text-weight-bold">
                            <span class="tag is-primary is-light is-medium">
                                {{ $data['waktu_mulai'] }} - {{ $data['waktu_berakhir'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <hr style="background-color: rgba(255,255,255,0.05);">

                <div class="content">
                    <h4 class="title is-6 has-text-danger mb-3">
                        <i class="fas fa-gavel mr-2"></i>Syarat & Ketentuan Lapangan
                    </h4>
                    <ol class="is-size-6" style="color: #e0e0e0;">
                        <li>Setiap peminjaman wajib melampirkan surat permohonan peminjaman yang mencantumkan secara detail
                            durasi penggunaan (waktu mulai hingga waktu berakhir).</li>
                        <li>Surat permohonan wajib diserahkan kepada pihak pengelola selambat-lambatnya H-3 sebelum jadwal
                            penggunaan lapangan.</li>
                        <li>Pengguna lapangan wajib menjaga dan mengembalikan kebersihan area lapangan segera setelah
                            penggunaan selesai.</li>
                        <li>Dilarang keras merusak, mengubah, atau menyalahgunakan seluruh fasilitas yang tersedia di area
                            lapangan.</li>
                        <li>Pelanggaran terhadap peraturan ini akan dikenakan Surat Peringatan Pertama (SP1). Jika
                            pelanggaran berulang, akan dikenakan Surat Peringatan Kedua (SP2) disertai penangguhan hak
                            peminjaman lapangan selama 1 (satu) bulan.</li>
                        <li>Pihak yang mendapatkan Surat Peringatan Kedua (SP2) diwajibkan membayar denda administratif
                            sebesar Rp50.000,-. Dana tersebut akan dialokasikan sepenuhnya untuk pengadaan fasilitas
                            kebersihan lapangan.</li>
                    </ol>
                </div>

                <form action="{{ route('schedule.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nama_peminjam" value="{{ $data['nama_peminjam'] }}">
                    <input type="hidden" name="nama_kegiatan" value="{{ $data['nama_kegiatan'] }}">
                    <input type="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
                    <input type="hidden" name="waktu_mulai" value="{{ $data['waktu_mulai'] }}">
                    <input type="hidden" name="waktu_berakhir" value="{{ $data['waktu_berakhir'] }}">

                    <div class="field box"
                        style="background-color: rgba(9, 132, 227, 0.05); border: 1px solid rgba(9, 132, 227, 0.2);">
                        <div class="control">
                            <label class="checkbox has-text-white">
                                <input type="checkbox" id="termsCheckbox" required>
                                <span class="ml-2">Saya telah membaca dan menyetujui ketentuan di atas.</span>
                            </label>
                        </div>
                    </div>

                    <div class="field is-grouped is-grouped-centered mt-6">
                        <p class="control">
                            <a href="javascript:history.back()" class="button is-light is-rounded">Kembali</a>
                        </p>
                        <p class="control">
                            <button type="submit" id="submitBooking" class="button is-primary is-rounded shadow-hover"
                                disabled>
                                <span class="icon is-small"><i class="fas fa-check"></i></span>
                                <strong>Setuju & Booking</strong>
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkbox = document.getElementById('termsCheckbox');
            const submitBtn = document.getElementById('submitBooking');

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    submitBtn.removeAttribute('disabled');
                } else {
                    submitBtn.setAttribute('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection
@extends('layouts.admin')

@section('title', 'Tinjau Pengaduan ' . $complaint->ticket_number)
@section('page_title', 'Detail & Pengelolaan Pengaduan')

@section('content')
    <div class="space-y-6" x-data="{ rejectModalOpen: false, statusModalOpen: false }">
        
        <!-- Top Back Nav -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-900 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Daftar Pengaduan
            </a>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-400">Status Saat Ini:</span>
                <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $complaint->status_badge_class }}">
                    {{ $complaint->status_label }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri & Tengah: Rincian Pengaduan & Tanggapan (Col-span 2) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card Utama Pengaduan -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                    
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nomor Tiket</span>
                            <div class="text-2xl font-black font-mono text-brand-900">{{ $complaint->ticket_number }}</div>
                        </div>
                        <div class="text-left sm:text-right text-xs text-slate-400">
                            <div>Diajukan pada:</div>
                            <div class="font-bold text-slate-700">{{ $complaint->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                    </div>

                    <!-- Judul & Deskripsi -->
                    <div>
                        <span class="inline-block px-3 py-1 rounded-lg bg-brand-50 text-brand-700 font-bold text-xs mb-3">
                            Kategori: {{ $complaint->category->name }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $complaint->title }}
                        </h2>
                        <div class="mt-4 p-5 bg-slate-50 rounded-2xl border border-slate-100 text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    <!-- Lokasi & Waktu Kejadian -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50/60 p-4 rounded-2xl border border-slate-100">
                        <div class="space-y-1">
                            <span class="text-slate-400 font-semibold block">Wilayah Administratif</span>
                            <div class="font-bold text-slate-800">Kec. {{ $complaint->kecamatan }}, Desa {{ $complaint->desa }}</div>
                            <div class="text-slate-500">{{ $complaint->location }}</div>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 font-semibold block">Tanggal Kejadian di Lapangan</span>
                            <div class="font-bold text-slate-800">{{ $complaint->incident_date->format('d F Y') }}</div>
                        </div>
                    </div>

                    <!-- Foto Bukti -->
                    @if($complaint->photo_path)
                        <div class="border-t border-slate-100 pt-5">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-3">Foto Bukti Terlampir</span>
                            <div class="max-w-md">
                                <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank" class="block group relative rounded-2xl overflow-hidden border border-slate-200">
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}" alt="Bukti Kejadian" class="w-full max-h-72 object-cover group-hover:scale-105 transition-transform">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-1.5">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                        <span>Buka Ukuran Asli</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Catatan Penolakan (Jika ada) -->
                    @if($complaint->status === \App\Models\Complaint::STATUS_DITOLAK && $complaint->rejection_reason)
                        <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 space-y-2">
                            <div class="flex items-center gap-2 font-bold text-rose-800 text-sm">
                                <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                                <span>Alasan Penolakan Oleh Admin:</span>
                            </div>
                            <p class="leading-relaxed pl-7 whitespace-pre-line">{{ $complaint->rejection_reason }}</p>
                        </div>
                    @endif

                </div>

                <!-- Card Tanggapan Resmi & Formulir Balas -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-5 h-5 text-emerald-600"></i>
                        Tanggapan Resmi Admin
                    </h3>

                    <!-- Riwayat Tanggapan Sebelumnya -->
                    @if($complaint->responses->count() > 0)
                        <div class="space-y-4">
                            @foreach($complaint->responses as $resp)
                                <div class="bg-emerald-50/50 border border-emerald-200/80 p-5 rounded-2xl space-y-2">
                                    <div class="flex items-center justify-between text-xs text-slate-500">
                                        <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                            {{ $resp->user ? $resp->user->name : 'Administrator' }}
                                        </span>
                                        <span>{{ $resp->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                                        {{ $resp->response }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 bg-slate-50 p-4 rounded-xl text-center">Belum ada tanggapan tertulis yang dikirimkan kepada pelapor.</p>
                    @endif

                    <!-- Formulir Tambah Tanggapan Baru -->
                    @if($complaint->status !== \App\Models\Complaint::STATUS_DITOLAK)
                        <form action="{{ route('admin.complaints.add-response', $complaint->id) }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3">
                            @csrf
                            <label for="response" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Tuliskan Tanggapan / Progres Terbaru Untuk Pelapor
                            </label>
                            <textarea id="response" name="response" rows="4" placeholder="Tuliskan tindakan yang telah diambil atau penjelasan resmi pihak pemerintah daerah..." required class="w-full p-4 bg-slate-50 border border-slate-300 rounded-2xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 leading-relaxed"></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                    Kirim Tanggapan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>

            <!-- Kolom Kanan: Aksi Status & Info Pelapor & Timeline (Col-span 1) -->
            <div class="space-y-6">
                
                <!-- Card Panel Aksi Verifikasi & Status -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="sliders" class="w-4 h-4 text-brand-600"></i>
                        Aksi Pengelolaan
                    </h3>

                    <!-- Tombol Verifikasi & Tolak (Jika Menunggu Verifikasi) -->
                    @if($complaint->status === \App\Models\Complaint::STATUS_MENUNGGU)
                        <div class="space-y-2 pt-1">
                            <form action="{{ route('admin.complaints.verify', $complaint->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pengaduan ini?')" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                    Verifikasi Pengaduan
                                </button>
                            </form>

                            <button type="button" @click="rejectModalOpen = true" class="w-full py-2.5 px-4 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                Tolak Pengaduan
                            </button>
                        </div>
                    @else
                        <!-- Form Ubah Status (Sedang Diproses / Selesai) -->
                        <div class="pt-2">
                            <button type="button" @click="statusModalOpen = true" class="w-full py-3 px-4 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                Perbarui Status Laporan
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Card Profil Pelapor -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-brand-600"></i>
                        Data Identitas Pelapor
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block font-medium">Nama Lengkap</span>
                            <span class="font-bold text-slate-800 block text-sm">{{ $complaint->user ? $complaint->user->name : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Nomor WhatsApp / HP</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $complaint->user ? $complaint->user->phone : '') }}" target="_blank" class="font-bold text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                {{ $complaint->user ? $complaint->user->phone : '-' }}
                            </a>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Alamat Email</span>
                            <span class="font-medium text-slate-700 block">{{ $complaint->user ? $complaint->user->email : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Domisili Akun</span>
                            <span class="font-medium text-slate-700 block">Kec. {{ $complaint->user ? $complaint->user->kecamatan : '-' }}, Desa {{ $complaint->user ? $complaint->user->desa : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Perubahan Status -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="history" class="w-4 h-4 text-brand-600"></i>
                        Riwayat Perubahan Status
                    </h3>

                    <div class="relative pl-5 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 text-xs">
                        @foreach($complaint->statusHistories as $hist)
                            <div class="relative">
                                <div class="absolute -left-5 top-1 w-4 h-4 rounded-full border-2 border-white bg-brand-600 shadow-sm"></div>
                                <div class="font-bold text-slate-800">{{ $hist->new_status_label }}</div>
                                <div class="text-[11px] text-slate-400">{{ $hist->created_at->format('d/m/Y H:i') }}</div>
                                @if($hist->note)
                                    <div class="text-[11px] text-slate-600 mt-1 bg-slate-50 p-2 rounded-lg border border-slate-100 leading-relaxed">
                                        {{ $hist->note }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- Modal Tolak Pengaduan -->
        <div x-show="rejectModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.outside="rejectModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4 shadow-2xl">
                <div class="flex items-center gap-3 text-rose-600">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tolak Pengaduan Ini</h3>
                        <p class="text-xs text-slate-500">Ketikkan alasan penolakan secara jelas dan objektif</p>
                    </div>
                </div>

                <form action="{{ route('admin.complaints.reject', $complaint->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="rejection_reason" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alasan Penolakan <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4" required placeholder="Contoh: Pengaduan ditolak karena merupakan sengketa perdata keluarga pribadi dan di luar wewenang dinas..." class="w-full p-3.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="rejectModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                            Konfirmasi Tolak Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Perbarui Status -->
        <div x-show="statusModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.outside="statusModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4 shadow-2xl">
                <div class="flex items-center gap-3 text-brand-600">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Perbarui Status Penanganan</h3>
                        <p class="text-xs text-slate-500">Pilih status terbaru dan tambahkan catatan proses jika ada</p>
                    </div>
                </div>

                <form action="{{ route('admin.complaints.update-status', $complaint->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Status Baru <span class="text-rose-500">*</span>
                        </label>
                        <select id="status" name="status" required class="w-full p-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="diverifikasi" {{ $complaint->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi (Telah lolos verifikasi berkas)</option>
                            <option value="sedang_diproses" {{ $complaint->status == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses (Petugas sedang menangani di lapangan)</option>
                            <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai (Penanganan keluhan telah tuntas)</option>
                        </select>
                    </div>

                    <div>
                        <label for="note" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Catatan Perubahan (Opsional)
                        </label>
                        <textarea id="note" name="note" rows="3" placeholder="Contoh: Tim teknis PDAM telah diterjunkan ke lokasi pipa bocor..." class="w-full p-3 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="statusModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection


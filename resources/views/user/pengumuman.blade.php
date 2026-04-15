@extends('user.layouts.app')
@section('content')
    <div class="card mb-4 shadow-sm mt-3 mx-auto">
        <div class="card-header text-white d-flex align-items-center" style="background-color: #007A3E">
            <h5 class="card-title mb-0">Pengumuman</h5>
        </div>
        <div class="card-body">
            @forelse($pengumumans as $pengumuman)
                <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                    <i class="fas fa-bullhorn text-primary me-2"></i> <!-- Ikon Pengumuman -->
                    <p class="mb-0">
                        <strong>{{ $loop->iteration }}.</strong>
                        <a href="{{ route('pengumumanUser.show', $pengumuman->id) }}" class="text-decoration-none">
                            {{ $pengumuman->judul }}
                        </a>
                    </p>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada pengumuman.</p>
            @endforelse
        </div>
    </div>
@endsection

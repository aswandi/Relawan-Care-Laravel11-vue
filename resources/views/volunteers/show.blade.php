@extends('layout.app')

@section('title', 'Detail Relawan')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Detail Relawan
                </h5>
                <div>
                    <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('volunteers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 40%">Kode Relawan</td>
                                <td>{{ $volunteer->volunteer_code }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama Lengkap</td>
                                <td>{{ $volunteer->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nomor Telepon</td>
                                <td>{{ $volunteer->phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status</td>
                                <td>
                                    @if($volunteer->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 40%">Kabupaten</td>
                                <td>{{ $volunteer->kabupaten->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kecamatan</td>
                                <td>{{ $volunteer->kecamatan->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Desa</td>
                                <td>{{ $volunteer->desa->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bergabung</td>
                                <td>{{ $volunteer->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <h6 class="fw-bold">Alamat</h6>
                    <p class="text-muted">{{ $volunteer->address }}</p>
                </div>
            </div>
        </div>

        <!-- Activities Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Aktivitas
                </h5>
            </div>
            <div class="card-body">
                @if($volunteer->activities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Penerima</th>
                                    <th>Sesi Bantuan</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($volunteer->activities as $activity)
                                    <tr>
                                        <td>{{ $activity->activity_date->format('d M Y H:i') }}</td>
                                        <td>{{ $activity->beneficiary->name }}</td>
                                        <td>{{ $activity->aidSession->name }}</td>
                                        <td>{{ $activity->latitude }}, {{ $activity->longitude }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <p>Belum ada aktivitas yang tercatat</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
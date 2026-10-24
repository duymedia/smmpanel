@extends('admin.layouts.app')
@section('title', 'Backup')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card shadow-sm">
            <div class="card-body">
                @if (count($files) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-7 gy-2 gs-3 mb-0">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Created</th>
                                    <th>Downloaded</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $file)
                                    <tr>
                                        <td class="fw-bold ls-1">{{ $file['name'] }}</td>
                                        <td>{{ $file['size'] }}</td>
                                        <td>{{ $file['created'] }}</td>
                                        <td>{{ $file['downloaded'] }}</td>
                                        <td>
                                            <a href="{{ route('admin.backup.download', ['file' => $file['name']]) }}"
                                                class="btn btn-sm btn-light-primary">Download</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-muted fs-6">Chưa có dữ liệu backup.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

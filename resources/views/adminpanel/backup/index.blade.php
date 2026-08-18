@extends('adminpanel.layouts.app')
@section('title', 'Backup')
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="alert alert-primary d-flex align-items-center p-5 mb-5 d-none">
            <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span
                    class="path2"></span></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-primary">This is an alert</h4>
                <span>The alert component can be used to highlight certain parts of your page for higher content
                    visibility.</span>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <!--begin::Table-->
                <div class="table-resppnsive">
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
                            <tr>
                                <td class="fw-bold ls-1">2024-10.zip</td>
                                <td>0.11 MB</td>
                                <td>2025-05-03 02:19:05</td>
                                <td></td>
                                <td>
                                    <form action="" method="POST"><button type="submit" name="download"
                                            value="2024-10.zip" class="btn btn-sm btn-light-primary">Download</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2024-11.zip</td>
                                <td>0.56 MB</td>
                                <td>2025-06-03 02:17:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2024-11.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2024-12.zip</td>
                                <td>0.48 MB</td>
                                <td>2025-07-03 02:13:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2024-12.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-01.zip</td>
                                <td>0.22 MB</td>
                                <td>2025-08-03 02:16:05</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-01.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-02.zip</td>
                                <td>0.46 MB</td>
                                <td>2025-09-03 02:14:07</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-02.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-03.zip</td>
                                <td>0.82 MB</td>
                                <td>2025-10-03 02:15:05</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-03.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-04.zip</td>
                                <td>0.38 MB</td>
                                <td>2025-11-03 02:16:05</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-04.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-05.zip</td>
                                <td>0.39 MB</td>
                                <td>2025-12-03 02:18:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-05.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-06.zip</td>
                                <td>0.25 MB</td>
                                <td>2026-01-03 02:16:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-06.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-07.zip</td>
                                <td>0.24 MB</td>
                                <td>2026-02-03 02:14:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-07.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-08.zip</td>
                                <td>0.43 MB</td>
                                <td>2026-03-03 02:20:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-08.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                            <tr>
                                <td class="fw-bold ls-1">2025-09.zip</td>
                                <td>0.23 MB</td>
                                <td>2026-04-03 02:18:04</td>
                                <td></td>
                                <td><button type="submit" name="download" value="2025-09.zip"
                                        class="btn btn-sm btn-light-primary">Download</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

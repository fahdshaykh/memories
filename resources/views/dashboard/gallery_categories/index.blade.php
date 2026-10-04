@extends('dashboard.layouts.admin')

@section('title', 'Gallery Categories - Admin Dashboard')

@section('script')
<script src="{{ asset('admin/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/page/datatables.js') }}"></script>
@endsection

@section('content')
<style>
.sharp-corner,
.sharp-corner * {
    border-radius: 0 !important;
}
.cat-thumb-box {
    width: 56px;
    height: 56px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    border-radius: 0 !important;
}
.cat-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0 !important;
}
.cat-thumb-placeholder {
    color: #94a3b8;
    font-size: 20px;
}
.cat-badge-count {
    background: #212529;
    color: #fff;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 0 !important;
    display: inline-block;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div id="status-success" class="alert alert-success sharp-corner" style="display:none;"></div>
            
            <div class="card sharp-corner">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gallery Categories</h4>
                    <a href="{{ route('galleries.categories.create') }}" class="btn btn-primary sharp-corner">
                        <i class="fas fa-plus mr-1"></i> Add Gallery Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover sharp-corner" id="save-stage" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th style="width: 80px;">Cover</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th style="width: 120px;">Total Photos</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $serial = 1; @endphp
                                @foreach($categories as $row)
                                    @php
                                        $imagePath = $row->image;
                                        if ($imagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                                            $imgUrl = asset('storage/' . $imagePath);
                                        } elseif ($imagePath && file_exists(public_path('category_images/' . basename($imagePath)))) {
                                            $imgUrl = asset('category_images/' . basename($imagePath));
                                        } else {
                                            $imgUrl = asset('default.png');
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $serial }}</td>
                                        <td>
                                            <div class="cat-thumb-box">
                                                @if($row->image)
                                                    <img src="{{ $imgUrl }}" alt="{{ $row->title }}" onerror="this.onerror=null; this.src='{{ asset('default.png') }}';">
                                                @else
                                                    <div class="cat-thumb-placeholder">
                                                        <i class="fas fa-images"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $row->title }}</strong>
                                            @if($row->content)
                                                <div class="text-muted small text-truncate" style="max-width: 260px;">
                                                    {{ Str::limit(strip_tags($row->content), 70) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td><code>{{ $row->slug }}</code></td>
                                        <td>
                                            <span class="cat-badge-count">
                                                {{ $row->galleries_count ?? 0 }} Images
                                            </span>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" id="cat-{{ $row->id }}"
                                                    onclick="changeCategoryStatus(event.target, {{ $row->id }});" {{ $row->status ? 'checked' : '' }}>
                                                <span class="slider round" style="border-radius: 0 !important;"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="btn-group align-top sharp-corner">
                                                <a href="{{ route('galleries.categories.edit', ['category' => $row->id]) }}" 
                                                   class="btn btn-sm btn-outline-primary sharp-corner mr-1" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form method="post" action="{{ route('galleries.categories.destroy', ['category' => $row->id]) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this gallery category?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger sharp-corner" type="submit" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $serial++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeCategoryStatus(_this, id) {
    var status = $(_this).prop('checked') == true ? 1 : 0;

    $.ajax({
        url: "{{ route('galleries.categories.status') }}",
        type: 'GET',
        data: {
            id: id,
            status: status 
        },
        success: function (result) {
            $("#status-success").show().html(result.success);
            setTimeout(function() {
                $("#status-success").fadeOut();
            }, 3000);
        },
        error: function() {
            alert('Failed to update category status.');
            $(_this).prop('checked', !status);
        }
    });
}
</script>
@endsection

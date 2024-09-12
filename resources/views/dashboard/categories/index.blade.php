@extends('dashboard.layouts.admin')

@section('script')

<script src="{{asset('admin/assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/page/datatables.js')}}"></script>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h4>Category List</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Serrial.#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial = 1; ?>
                    @foreach($categories as $row)
                        <tr>
                            <td>{{$serial}}</td>
                            <td>{{$row->title}}</td>

                            <td>
                                <label class="switch">
                                    <input type="checkbox" id="user-{{$row->id}}"
                                        onclick="changeCategoryStatus(event.target, {{ $row->id }});"{{($row->status) ? 'checked' : ''}}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            
                            <td>
                            <div class="btn-group align-top">
                                
                                <button class="btn btn-default"><a href="{{ route('categories.edit', ['category' => $row->id]) }}"><i class="fas fa-pen" style="font-size:15px;"></i></a></button>
                            
                            
                                <form method="post" action="{{ route('categories.destroy', ['category' => $row->id]) }}" class="user-delete-btn"
                                onsubmit="return confirm('Are You Sure Want To Delete?');">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-default" type="submit">
                                    <i class="fas fa-trash-alt" style="font-size:15px;color:red"></i></button>
                                </form>
                                
                            </div>

                            </td>
                        </tr>
                        <?php $serial++; ?>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

function changeCategoryStatus(_this, id) {

    var status = $(_this).prop('checked') == true ? 1 : 0;

    $.ajax({
        url: "{{url('category-status')}}",
        type: 'GET',
        data: {
            id: id,
            status: status 
        },

        success: function (result) {
            $("#status-success").show();
            $("#status-success").html(result.success);
            setTimeout(function() {
            $("#status-success").hide()
            }, 3000);

        }
    });
}
</script>
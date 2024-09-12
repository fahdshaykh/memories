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
                <h4>Posts list</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Serrial.#</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial = 1; ?>
                    @foreach($posts as $row)
                        <tr>
                            <td>{{$serial}}</td>
                            <td>{{$row->category->title}}</td>
                            <td>{{$row->title}}</td>
                            <td>
                            <div class="btn-group align-top">
                                
                                <button class="btn btn-default"><a href="{{ route('posts.edit', ['post' => $row->id]) }}"><i class="fas fa-pen" style="font-size:15px;"></i></a></button>
                            
                            
                                <form method="post" action="{{ route('posts.destroy', ['post' => $row->id]) }}" class="user-delete-btn"
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
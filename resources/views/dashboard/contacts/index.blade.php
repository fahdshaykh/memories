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
                <h4>Contact Messages</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial = 1; ?>
                    @foreach($contacts as $contact)
                        <tr @if(!$contact->is_read) style="background-color: #fff3cd;" @endif>
                            <td>{{$serial}}</td>
                            <td>
                                @if($contact->is_read)
                                    <span class="badge badge-success">Read</span>
                                @else
                                    <span class="badge badge-warning">New</span>
                                @endif
                            </td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ Str::limit($contact->subject, 30) }}</td>
                            <td>{{ $contact->created_at->format('M d, Y') }}</td>
                            <td>
                            <div class="btn-group align-top">
                                <button class="btn btn-default">
                                    <a href="{{ route('contacts.show', ['contact' => $contact->id]) }}" title="View">
                                        <i class="fas fa-eye" style="font-size:15px;"></i>
                                    </a>
                                </button>

                                @if($contact->is_read)
                                <form method="post" action="{{ route('contacts.mark-unread', ['contact' => $contact->id]) }}" style="display: inline;">
                                    @method('PUT')
                                    @csrf
                                    <button class="btn btn-default" type="submit" title="Mark as Unread">
                                        <i class="fas fa-envelope" style="font-size:15px;"></i>
                                    </button>
                                </form>
                                @else
                                <form method="post" action="{{ route('contacts.mark-read', ['contact' => $contact->id]) }}" style="display: inline;">
                                    @method('PUT')
                                    @csrf
                                    <button class="btn btn-default" type="submit" title="Mark as Read">
                                        <i class="fas fa-envelope-open" style="font-size:15px;"></i>
                                    </button>
                                </form>
                                @endif

                                <form method="post" action="{{ route('contacts.destroy', ['contact' => $contact->id]) }}"
                                onsubmit="return confirm('Are You Sure Want To Delete This Message?');">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-default" type="submit" title="Delete">
                                    <i class="fas fa-trash-alt" style="font-size:15px;color:red"></i>
                                </button>
                                </form>
                            </div>
                            </td>
                        </tr>
                        <?php $serial++; ?>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $contacts->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

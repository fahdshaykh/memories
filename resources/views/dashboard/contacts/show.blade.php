@extends('dashboard.layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Message Details</h4>
                        <div>
                            <a href="{{ route('contacts.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                                <i class="fas fa-reply"></i> Reply via Email
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>From:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $contact->name }} ({{ $contact->email }})
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <strong>Subject:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $contact->subject }}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <strong>Date Sent:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $contact->created_at->format('l, F j, Y \a\t g:i A') }}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-md-9">
                            @if($contact->is_read)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-warning">New</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <strong>Message:</strong>
                            <div class="mt-3 p-3" style="background-color: #f9f9f9; border-left: 3px solid #333; white-space: pre-wrap;">{{ $contact->message }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if($contact->is_read)
                            <form method="post" action="{{ route('contacts.mark-unread', ['contact' => $contact->id]) }}" style="display: inline;">
                                @method('PUT')
                                @csrf
                                <button class="btn btn-warning" type="submit">
                                    <i class="fas fa-envelope"></i> Mark as Unread
                                </button>
                            </form>
                            @else
                            <form method="post" action="{{ route('contacts.mark-read', ['contact' => $contact->id]) }}" style="display: inline;">
                                @method('PUT')
                                @csrf
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-envelope-open"></i> Mark as Read
                                </button>
                            </form>
                            @endif
                        </div>
                        <div>
                            <form method="post" action="{{ route('contacts.destroy', ['contact' => $contact->id]) }}"
                            onsubmit="return confirm('Are You Sure Want To Delete This Message?');">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit">
                                <i class="fas fa-trash-alt"></i> Delete Message
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

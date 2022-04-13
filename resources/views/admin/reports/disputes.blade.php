@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Disputes <small>Control panel</small></h1>
            @include('admin.common.breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Disputes</h3>
                        </div>

                        <div class="box-body">
                            <div class="">
                                <table class="table table-striped table-hover dt-responsive" id="datatable" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>Property Name</th>
                                            <th>Host Email</th>
                                            <th>Guest Email</th>
                                            <th>Confirmation Code</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alldisputes as $item)
                                            @php
                                                $property = App\Models\Properties::where('id', $item->property_id)->first();
                                                $hostemail = App\Models\User::where('id', $item->host_id)->first()->email;
                                                $guestemail = App\Models\User::where('id', $item->guest_id)->first()->email;
                                            @endphp
                                            <tr>
                                                <td>{{ $property->name }}</td>
                                                <td>{{ $hostemail }}</td>
                                                <td>{{ $guestemail }}</td>
                                                <td>{{ $item->confirmation_code }}</td>
                                                <td>{{ $item->comment }}</td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('public/backend/plugins/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
{{-- {!! $dataTable->scripts() !!} --}}
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "order": [], //Initial no order.
            "aaSorting": [],
        });
    } );
</script>
@endpush

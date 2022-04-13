@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Blogs <small>Control panel</small></h1>
            @include('admin.common.breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Blogs Management</h3>
                            @if(Auth::guard('admin')->user())
                                <div class="pull-right"><a class="btn btn-success" href="{{ url('admin/blogs/add-new-blog') }}">Add Blogs</a></div>
                            @endif
                        </div>

                        <div class="box-body">
                            <div class="">
                                <table class="table table-striped table-hover dt-responsive" id="datatable" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blogs as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    <img src="{{ asset('public/front/images/blogs') }}/{{ $item->image }}" style="height: 30px; width: 50px;" alt="">
                                                    {{ $item->title }}
                                                </td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    @if ($item->status == '1')
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.editBlog',['id'=>$item->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a href="{{ route('admin.deleteBlogPost',['id'=>$item->id]) }}" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>
                                                </td>
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
        $('#datatable').DataTable();
    } );
</script>
@endpush

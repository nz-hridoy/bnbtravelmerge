@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Edit Blog <small>Control panel</small></h1>
            @include('admin.common.breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Blog</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-9">
                                    <form class="form-horizontal" action="{{ route('admin.updateBlog') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Title <span class="text-danger">*</span></label>
                                            <div class="col-sm-8" id="respo">
                                                <input type="text" name="title" id="title" class="form-control" value="{{ $blog->title }}" />
                                                @error('title')
                                                    <span style="font-size: 12.5px; color: red;">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Short Description <span class="text-danger">*</span></label>
                                            <div class="col-sm-8" id="respo">
                                                <textarea name="description" rows="3" class="form-control">{{ $blog->description }}</textarea>
                                                @error('description')
                                                    <span style="font-size: 12.5px; color: red;">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Post Content <span class="text-danger">*</span></label>
                                            <div class="col-sm-8" id="respo">
                                                <textarea name="content" rows="5" id="content" class="form-control">{{ $blog->content }}</textarea>
                                                @error('content')
                                                    <span style="font-size: 12.5px; color: red;">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Image <span class="text-danger">*</span></label>
                                            <div class="col-sm-8" id="respo">
                                                <input type="file" name="image" class="form-control" />
                                            
                                                @error('image')
                                                    <span style="font-size: 12.5px; color: red;">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Status <span class="text-danger">*</span></label>
                                            <div class="col-sm-8" id="respo">
                                                <select name="status" class="form-control">
                                                    <option value="">Select status</option>
                                                    <option value="1" @if($blog->status == '1') selected @endif>Active</option>
                                                    <option value="0" @if($blog->status == '0') selected @endif>Inactice</option>
                                                </select>
                                                @error('status')
                                                    <span style="font-size: 12.5px; color: red;">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3"></label>
                                            <div class="col-sm-8" id="respo">
                                                <button type="submit" class="btn btn-info">Add Blog</button>
                                                <button type="button" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
 
<script>

  window.onload = function() {
    CKEDITOR.replace( 'content', {
      filebrowserUploadUrl: '{{ route('upload',['_token' => csrf_token() ]) }}',
      filebrowserUploadMethod: 'form'

    });
  };
</script>
<script>

  $(document).ready(function() {
   $('#page_url').on('blur keyup', function() {
     var pagUrl = $('#page_url').val();
     if (pagUrl !='') {
      $('.error-tag').hide();
    } 

  });
 });
</script>

<script>
   $(document).ready(function() {
   $('#geturl').on('blur keyup', function() {
     var pagUrl = $('#geturl').val();
         pagUrl = pagUrl.toLowerCase();
         pagUrl = pagUrl.replace(/[^a-zA-Z0-9]+/g,'-');
       if (pagUrl !='') {

      $('#page_url').val(pagUrl);
    } 

  });
 }); 
</script>


<script>

  $(document).ready(function() {
   $(document).on('submit', 'form', function() {
     $('button').attr('disabled', 'disabled');
   });
 });
</script>
<script type="text/javascript">
 $(document).ready(function () {


  $('#add_page').validate({
    ignore: [],
    rules: {
      name: {
        required: true
      },
      url:{
        required:true
      },
       content: {

        required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                    return editorcontent.length === 0;
                  }
                }
              },
              errorPlacement: function (error, element) {
                if (element.prop('type') === 'textarea') {
                  $('#content-validation-error').html(error);
                } else {
                  error.insertAfter(element);
                }
              }
      });
});

</script>
@endpush


@extends('admin.layouts.app')
 
 @section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="row mb-2">
              <div class="col-md-6">
                  <form action="">
                      <div class="input-group">
                          <input id="search" type="search" class="form-control form-control-lg" placeholder="Search user">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-lg btn-default">
                                  <i class="fa fa-search"></i>
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-12">
            <h3 class="card-title">Users</h3>
            </div>
          </div>
          @include("admin.components.message")

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped Users">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          User Name
                      </th>
                      <th style="width: 30%">
                          User Email
                      </th>
                      <th>
                          Login Type
                      </th>
                      <th style="width: 8%" class="text-center">
                          Status
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="#">
                            {{ $user->name }}
                          </a>
                          <br/>
                          <small>
                              Created {{ $user->created_at }}
                          </small>
                      </td>
                      <td>
                          <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                      </td>
                      <td>
                          Email
                      </td>
                      <td class="project-state">
                          <span class="badge {{ $user->deleted_at ? 'badge-danger' : 'badge-success' }}">{{ $user->deleted_at ? "Deleted" : "Active" }}</span>
                      </td>
                      @if(!$user->deleted_at)
                      <td class="project-actions text-right">
                          <form style="display: none" action="{{ route('admin.user.destroy',$user->id ) }}" method="post" id="del-form-{{ $user->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            <a class="btn btn-danger btn-sm" onclick="
                                 if (confirm('Are You Sure to delete user {{ $user->name }}?')){
                                     event.preventDefault();
                                     document.getElementById('del-form-{{ $user->id }}').submit();
                                 }else {
                                     event.preventDefault();
                                 }">
                                 <i class="fas fa-trash"></i>
                                Delete
                            </a>
                      </td>
                      @else
                      <td class="project-actions text-right">
                          <form style="display: none" action="{{ route('admin.user.activate',$user->id ) }}" method="post" id="activate-form-{{ $user->id }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                            </form>
                            <a class="btn btn-success btn-sm" onclick="
                                 if (confirm('Are You Sure to activate user {{ $user->name }}?')){
                                     event.preventDefault();
                                     document.getElementById('activate-form-{{ $user->id }}').submit();
                                 }else {
                                     event.preventDefault();
                                 }">
                                 <i class="fas fa-edit"></i>
                                Activate
                            </a>
                      </td>
                      @endif
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@section("js")

<script>
document.addEventListener("DOMContentLoaded", (e)=>{
    $('#search').on('keyup', function(){
        search();
    });
    search();



    function search(){
        var keyword = $('#search').val();
        $.post('{{ route("admin.users.search") }}',
          {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keyword:keyword
          },
          function(data){
            postDataTable(data);
          });
    }



    // table row with ajax
    function postDataTable(res){
      let htmlView = '';
      if(res.employees.length <= 0){
          htmlView+= `
            <tr>
                <td colspan="6">No users found.</td>
            </tr>`;
      }
      for(let i = 0; i < res.employees.length; i++){
            if(!res.employees[i].deleted_at){
                htmlView += `<tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="#">
                            ${res.employees[i].name}
                          </a>
                          <br/>
                          <small>
                              Created ${res.employees[i].created_at}
                          </small>
                      </td>
                      <td>
                          <a href="mailto:${res.employees[i].email}">${res.employees[i].email}</a>
                      </td>
                      <td>
                          Email
                      </td>
                      <td class="project-state">
                          <span class="badge ${res.employees[i].deleted_at ? "badge-danger" : "badge-success"}">${res.employees[i].deleted_at ? "Deleted" : "Active"}</span>
                      </td>
                      <td class="project-actions text-right">
                            <form style="display: none" action="/control/admin/users/delete/${res.employees[i].id}" method="post" id="del-form-${res.employees[i].id}">
                            {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            <a class="btn btn-danger btn-sm" onclick="
                                 if (confirm('Are You Sure to delete user ${res.employees[i].name}?')){
                                     event.preventDefault();
                                     document.getElementById('del-form-${res.employees[i].id}').submit();
                                 }else {
                                     event.preventDefault();
                                 }">
                                 <i class="fas fa-trash"></i>
                                Delete
                            </a>
                      </td>
                    </tr>`;
            }else{
                htmlView += `<tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="#">
                            ${res.employees[i].name}
                          </a>
                          <br/>
                          <small>
                              Created ${res.employees[i].created_at}
                          </small>
                      </td>
                      <td>
                          <a href="mailto:${res.employees[i].email}">${res.employees[i].email}</a>
                      </td>
                      <td>
                          Email
                      </td>
                      <td class="project-state">
                          <span class="badge ${res.employees[i].deleted_at ? "badge-danger" : "badge-success"}">${res.employees[i].deleted_at ? "Deleted" : "Active"}</span>
                      </td>
                      <td class="project-actions text-right">
                            <form style="display: none" action="/control/admin/users/activate/${res.employees[i].id}" method="post" id="activate-form-${res.employees[i].id}">
                            {{ csrf_field() }}
                                {{ method_field('PUT') }}
                            </form>
                            <a class="btn btn-success btn-sm" onclick="
                                 if (confirm('Are You Sure to delete user ${res.employees[i].name}?')){
                                     event.preventDefault();
                                     document.getElementById('activate-form-${res.employees[i].id}').submit();
                                 }else {
                                     event.preventDefault();
                                 }">
                                 <i class="fas fa-edit"></i>
                                Activate
                            </a>
                      </td>
                    </tr>`;
            }
        }
        $('tbody').html(htmlView);
    }
})
</script>


@endsection

@endsection

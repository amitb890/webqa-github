@extends('layouts.app')
@section('title', 'Webqa - Projects')
@section('css')
<link rel="stylesheet" href="{{ asset('new-assets/vendor/sweet-alert/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/css/project.list.css') }}">
@endsection
@section('content')
    <!-- Ui-Element Start -->
    <div class="element-main-area">
        <div class="element-cls">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="element_All">
                <label class="form-check-label" for="element_All">
                    Select All
                </label>
            </div>
            <span><i class="fa-solid fa-xmark"></i></span>
        </div>
        <input type="hidden" id="projectCount" value="{{ count($projects) }}">

    </div>
    <!-- Ui-Element End -->
    <div class="project_area">
        <div class="project_top_area">
            <div class="project_title">
                <h2>Projects</h2>
                <form action="{{ route('projects.index') }}" method="GET" class="d-flex">

                </form>
                <a href="{{ route('projects.create') }}" class="btn btn_primary rounded-pill">Add New Project</a>
            </div>
            <!-- Project Table -->
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="project_table_area_datatable" style="height: auto">
                <div class="table-responsive">
                    <table id="" class="table" style="width: 100%">
                        <thead class="project_table_header">
                            <tr>
                                <th>Project Name</th>
                                <th>Root URL</th>
                                <th scope="col" class="project_action">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="project_table_td">
                        @foreach($projects as $key=>$data)
                            <tr class="project_row" id="project_{{ $data->id }}">
                              <td class="project_name">
                                @if($data->favicon == "default" || $data->favicon == "")
                                <img src="/new-assets/assets/images/amazon.png" alt="icon">
                                @else
                                <img src="{{ $data->favicon }}" alt="icon">
                                @endif
                                <p>{{$data->name}} </p>
                              </td>
                              <td>{{ $data->homepage }}</td>
                              <td class="project_action"><span class="project_action">
                                <a href="/projects/{{ $data->id }}/edit"> <img
                                    src="/new-assets/assets/images/project/edit.png" alt="icon"
                                    data-id="{{ $data->id }}" title="Edit"> </a>
                                <a href="/settings/{{ $data->id }}/edit"> <img
                                    src="/new-assets/assets/images/project/setting.png" alt="icon"
                                    title="Setting"></a>
                                <img src="/new-assets/assets/images/project/delete.png" alt="icon"
                                    class="deleteProject" data-id="{{ $data->id }}" data-name="{{ $data->name }}" title="Delete"><span>
                            </td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('new-assets/vendor/sweet-alert/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('new-assets/js/project-list.js') }}"></script>
@endsection
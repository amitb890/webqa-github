@extends('layouts.app')
@section('content')
    <div class="project_area">
        <div class="project_top_area">
            <div class="project_title">
                <h2>Edit Project</h2>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" value="{{ $settingsSubId }}" id="settingsSubId">
            <input type="hidden" value="1" id="unique_name_project_valid">
            <input type="hidden" value="1" id="check_valid_url">
            
            
            <input type="hidden" value="{{ $id }}" id="projectId">
            <div class="add_project_area">
                <div class="project_section">
                    <form class="form-top form-body">
                        <p>Enter your new project details below:</p>
                        <div class="col-md-6 project-single-input">
                            <label for="name" class="form-label">Project Name</label>
                            <input type="hidden" id="project_id" value="{{ $project->id }}">
                            <input type="text" class="form-control" id="name" value="{{ $project->name }}"
                                required />
                            <span class="invalid_sitemapUrl invalid_name" style="display: none">Project name already exist.</span>
                        </div>
                        <div class="col-md-6 project-single-input">
                            <label for="name" class="form-label">Project URL</label>
                            <input type="text" class="form-control is-valid" value="{{ $project->homepage }}"
                                id="homepage" />
                            <span class="invalid_sitemapUrl invalid_url" style="display: none">URL is not valid.</span>
                            <span class="valid_url" style="display: none; color: green">URL validated.</span>
                                  
                            {{-- <span>URL validated</span> --}}
                        </div>
                        <div class="col-md-12 project-single-input">
                            <label for="name" class="form-label">List of urls</label>
                            <textarea name="" id="urlsList" class="col-md-12" placeholder="Enter each url in new line">@foreach ($project->urls as $item){{ $item->url }}&#10;@endforeach</textarea>
                            <span class="total_url" style="display: none; color: green"></span>
                        </div>
                        <div class="main_sitemap_area">
                            <div class="sitemap_area">
                                <div class="col-md-6 project-single-input">
                                    <label for="name" class="form-label">XML Sitemap</label>
                                    <input type="text" class="form-control" id="xmlSitemap" value="" />
                                </div>
                                <a class="sitemap_btn xml_sitemap_btn" style="text-decoration: none;">+ Add</a>
                            </div>
                            <ol class="sitemap_input">
                                <span class="xml_sitemap_li sitemap_li"></span>
                                @foreach ($xmlSitemap as $itemXml)
                                    @if ($itemXml != '')
                                        <li class="xml_sitemap_li sitemap_li"><span
                                                class="xml_sitemap_vlaue">{{ $itemXml }}</span><button type="button"
                                                class="sitemap_input_btn"><i class="fa-solid fa-xmark"></i></button></li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                        <div class="main_sitemap_area">
                            <div class="sitemap_area">
                                <div class="col-md-6 project-single-input">
                                    <label for="name" class="form-label">HTML Sitemap</label>
                                    <input type="text" class="form-control" id="htmlSitemap" value="" />
                                </div>
                                <a class="sitemap_btn html_sitemap_btn" style="text-decoration: none;">+ Add</a>
                            </div>
                            <ol class="sitemap_input">
                                <span class="html_sitemap_li sitemap_li"></span>
                                @foreach ($htmlSitemap as $itemHtml)
                                    @if ($itemHtml != '')
                                        <li class="html_sitemap_li sitemap_li"><span
                                                class="html_sitemap_vlaue">{{ $itemHtml }}</span><button type="button"
                                                class="sitemap_input_btn"><i class="fa-solid fa-xmark"></i></button></li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>

                        <div class="project_table_url">
                            <div class="table-responsive">
                                <div class="project_url_searchArea" style="width: 30%">
                                    <div class="project-single-input">
                                        <label for="name" class="form-label">Search URL</label>
                                        <input type="search" class="form-control" id="project_url_search" value=""
                                            placeholder="">
                                    </div>
                                    <button type="button" class="btn btn_primary url_search_edit">Search</button>
                                </div>
                                <h6 class="project_url_title" style="display: none">URL list</h6>
                                <table class="table">
                                    <tbody class="project_table_td">
                                        @foreach ($project->urls as $key=>$item1)
                                        <tr class="project_row project_data_tr_{{ $key }} project_data_tr" data-url="{{ $item1->url }}" style="display: none">
                                            <td class="project_url_data" ><input type="text" data-id="{{ $key }}"
                                                    value="{{ $item1->url }}" class="project_url_text_{{ $key }} project_url_text"
                                                    style="border: 0px; width: 100%" disabled="">
                                                    <span class="invalid_url search_url_invalid search_url_invalid_{{ $key }}" style="color: red !important"></span>

                                                <div class="project_urlAction">
                                                    <img class="project_urlAction_edit" data-id={{ $key }} src="/new-assets/assets/images/project/edit.png" alt="icon">
                                                    <img class="project_urlAction_delete" data-id={{ $key }} src="/new-assets/assets/images/project/delete.png" alt="icon">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                           
                            {{-- <button type="button" class="url_saveBtn">Save</button> --}}
                        </div>
                        <button type="button" id="editProjectButton" class="project_primary_btn">Edit Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
        <script src="{{ asset('new-assets/js/project-main.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/js/project-edit.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
@endsection

@extends('layouts.app')
@section('title', 'Edit Project | Webqa')
@section('css')
<link rel="stylesheet" href="{{ asset('new-assets/css/project-forms.css') }}{{ \App\Http\Helpers::getCacheBuster() }}">
@endsection
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
                            <span class="invalid_sitemapUrl invalid_name" style="display: none">Project name already exists.</span>
                        </div>
                        <div class="col-md-6 project-single-input">
                            <label for="name" class="form-label">Project URL</label>
                            <input type="hidden" value="1" id="unique_homepage_project_valid">
                            <input type="text" class="form-control is-valid" value="{{ $project->homepage }}"
                                id="homepage" data-name="Website address" />
                            <span class="valid_url" style="display: none; color: green">URL validated.</span>
                            <span class="invalid_sitemapUrl invalid_homepage" style="display: none">Project URL already exists.</span>
                            <div id="sitemap-loader" style="display: none; margin-top: 10px;">
                                <span class="spinner-border spinner-border-sm me-2"></span><span id="loader-text">Detecting sitemaps...</span>
                            </div>
                            {{-- <span>URL validated</span> --}}
                        </div>
                        <div class="col-md-12 project-single-input">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <label for="name" class="form-label" style="margin-bottom: 0;">List of urls</label>
                                <span class="total_url" style="display: none; color: green; font-weight: 500;"></span>
                            </div>
                            <textarea name="" id="urlsList" class="form-control" rows="3" placeholder="Enter each url in new line">@foreach ($project->urls as $index => $item){{ $index + 1 }}. {{ $item->url }}&#10;@endforeach</textarea>
                            <div id="noUrlsDetectedMessage" style="display: none; margin-top: 10px; color: #6c757d; font-size: 14px; font-style: italic;">
                                We could not auto-detect any urls on your website, please enter URLs manually.
                            </div>
                        </div>
                        <div class="col-md-12 project-single-input">
                            <label for="name" class="form-label">XML Sitemaps</label>
                            <textarea class="form-control" id="xmlSitemap" rows="2" placeholder="Enter XML sitemap URLs (one per line)">@if(isset($xmlSitemap) && count($xmlSitemap) > 0)
@foreach ($xmlSitemap as $itemXml)
@if ($itemXml != ''){{ $itemXml }}
@endif
@endforeach
@endif</textarea>
                        </div>
                        <div class="main_sitemap_area">
                            <div class="sitemap_area">
                                <ol class="sitemap_input">
                                    <span class="xml_sitemap_li sitemap_li"></span>
                                </ol>
                            </div>
                        </div>

                        <button type="button" id="editProjectButton" class="btn btn_primary rounded-pill">Save Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
        <script src="{{ asset('new-assets/js/project-create.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/js/project-edit.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
@endsection

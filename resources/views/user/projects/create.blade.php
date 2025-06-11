@extends('layouts.app')
@section('title', 'Webqa - Add New Project')
@section('content')
    <div class="project_area">
        <div class="project_top_area">
            <div class="project_title">
                <h2>Add New Project</h2>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="add_project_area">
                <div class="project_section">
                    <form class="form-top form-body">
                        <p>Enter your new project details below:</p>
                        <div class="col-md-6 project-single-input">
                            <input type="hidden"  id="is_validation" value="1"/>
                            <input type="hidden" value="1" id="unique_name_project_valid">
                            <label for="name" class="form-label">Project Name</label>
                            <input type="hidden" id="project_id" value="0">
                            <input type="hidden" value="1" id="check_valid_url">
                            <input type="text" class="form-control" id="name" value="" required />
                            <span class="invalid_sitemapUrl invalid_name" style="display: none">Project name already exist.</span>
                        </div>
                        <div class="col-md-6 project-single-input">
                            <label for="name" class="form-label">Project URL</label>
                            <input type="text" class="form-control " id="homepage" />
                            <span class="invalid_sitemapUrl invalid_url" style="display: none">URL is not valid.</span>
                            <span class="valid_url" style="display: none; color: green">URL validated.</span>
                            {{-- <span>URL validated</span> --}}
                        </div>
                        <div class="col-md-12 project-single-input">
                            <label for="name" class="form-label">List of urls</label>
                            <textarea name="" rows="3" cols="30" id="urlsList" class="col-md-12" placeholder="Enter each url in new line"></textarea>
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
                            </ol>
                        </div>

                        <button type="button" id="createProjectButton" class="project_primary_btn">Add Project</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('new-assets/js/project-main.js') }}"></script>
@endsection

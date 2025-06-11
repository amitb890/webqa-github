<div class="table-responsive">
    <table class="table">
        <thead class="project_table_header">
            <tr>
                <th scope="col" class="p_name_pl">Project Name</th>
                <th scope="col">Root URL</th>
                <th scope="col" class="project_action">Actions</th>
            </tr>
        </thead>
        <tbody class="project_table_td">
            @foreach ($projects as $project)
                <tr class="project_row" id="project_{{ $project->id }}">
                    <td class="project_name">
                        @if ($project->favicon != 'default')
                            <img src="{{ $project->favicon }}" alt="icon">
                        @else
                            <img src="{{ asset('new-assets/assets/images/project/project_item1.png') }}" alt="icon">
                        @endif
                        <p>{{ $project->name }}</p>
                    </td>
                    <td>{{ $project->homepage }}</td>
                    <td class="project_action">
                        <a href="{{ route('projects.edit', ['project' => $project->id]) }}"> <img
                                src="{{ asset('new-assets/assets/images/project/edit.png') }}" alt="icon"
                                data-id="{{ $project->id }}" title="Edit"> </a>
                        <a href="{{ route('settings.edit', ['setting' => $project->id]) }}"> <img
                                src="{{ asset('new-assets/assets/images/project/setting.png') }}" alt="icon"
                                title="Setting"></a>
                        <img src="{{ asset('new-assets/assets/images/project/delete.png') }}" alt="icon"
                            class="deleteProject" data-id="{{ $project->id }}" title="Delete">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div class="text-center">
    {{ $projects->links('pagination::bootstrap-4') }}
</div>

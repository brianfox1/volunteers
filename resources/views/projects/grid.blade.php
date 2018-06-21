@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div >
                <div class="panel panel-default">

                    <div class="panel-heading">
                            <div class="row">
                            <div class="col-sm-2">
                                Project Information
                            </div>
                                <div class="col-sm-10">
                                    <div class="row project-info-wrap">
                                    <div class="col-md-2"><a href="#" id="add_project" class="btn btn-primary">Add new project</a></div>
<!--                                 <div class="col-md-2"><a href="{{ url('/project_export') }}" class="btn btn-default">Export</a></div> -->
                                <div class="col-md-5">
                                    <form method="POST" action="{{route('projects')}}" class="navbar-form navbar-search" role="search" style="margin: 0;padding-left: 20px;padding-right: 0;">
                                    {{ csrf_field() }}
                                        <div class="input-group">

                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-search btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="fa fa-btn fa-search"></span>
                                                    <span class="label-icon">
                                                        <?php if ($search_by == "") {
    echo "Search By";
} else if ($search_by == "project") {
    echo "Project Name";
}?>
                                                    </span>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                   <li>
                                                        <a href="#">
                                                            <span class="fa fa-btn fa-search"></span>
                                                            <span class="label-icon"> Search By</span>
                                                        </a>
                                                    </li>                                                   <li>
                                                        <a href="#">
                                                            <span class="fa fa-btn fa-search"></span>
                                                            <span class="label-icon">Project Name</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                            <input id="search_text" name="search_text" type="text" class="form-control" value="{{$search_text}}">

                                            <input name="search_by" id="search_by" value="{{$search_by}}" type="hidden" class="form-control">
                                             <input type="hidden" value="{{$sort_by}}" name="sort_by">
                                            <div class="input-group-btn">
                                            <input type="hidden" name="paginate_show" value="{{$paginate_show}}">
                                                <button type="submite" class="btn btn-search btn-default">
                                                Search
                                                </button>


                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form method="POST" action="{{route('projects')}}" role="sort">
                                    {{ csrf_field() }}
                                      <input type="hidden" name="search_by" value="{{$search_by}}">
                                      <input type="hidden" name="search_text" value="{{$search_text}}">
                                      <input type="hidden" name="paginate_show" value="{{$paginate_show}}">
                                      <select name="sort_by" class="form-control" id="sort_by" onchange="this.form.submit()">
                                        <option value="" <?php if ($sort_by == ''): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>Sort By</option>
                                        <option value="project" <?php if ($sort_by == 'project'): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>Project</option>

                                      </select>
                                    </form>
                                </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="panel-body" style="min-height: 500px;">
                      <div class="modal fade" id="projectModal" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title project_header">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{url('save_project')}}" id="project_form" name="project_add_edit">
                                {{ csrf_field() }}
                                <input type="hidden" id="project_id" name="id" value="{{ $data['id'] }}">
                                <div class='row'>
                                  <div class='col-md-6'>
                                    <div class="form-group">
                                        {!! Form::label('Manager') !!}
                                        {!! Form::select('manager_id', $data['managers'], $data['manager_id'], array('id'=>'manager_id','class'=>'form-control','placeholder'=>'Plese select', 'required' => 'required')) !!}
                                        <p id="manager_id_valid" style="margin-left: 40px; color: red;"><sub>Manager is required</sub></p>
                                    </div>
                                  </div>
                                  <div class='col-md-6'>
                                    <div class="form-group">
                                            {!! Form::label('Project type') !!}
                                            {!! Form::select('project_type', $data['project_types'], $data['project_type'], array('id'=>'project_type','class'=>'form-control','placeholder'=>'Plese select', 'required' => 'required')) !!}
                                            <p id="project_type_valid" style="margin-left: 40px; color: red;"><sub>Project type is required</sub></p>
                                        </div>
                                  </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            {!! Form::label('Project Name') !!}
                                            {!! Form::text('project', $data['project'], array('id'=>'project','class'=>'form-control','required' => 'required')); !!}
                                        <p id="project_valid" style="margin-left: 40px; color: red;"><sub>Project name is required</sub></p>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                                {!! Form::label('Deadline') !!}
                                                {!! Form::text('deadline', $data['deadline'], array('id'=>'deadline','class'=>'form-control','required' => 'required')); !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                       {!! Form::label('Description') !!}
                                       {!! Form::textArea('description', $data['description'], array('id'=>'description','class'=>'form-control','required' => 'required')); !!}
                                </div>
                                <div style="clear: both; padding-top: 10px;"></div>
                                <div class="form-group">
                                    {!! Form::label('Active') !!}
                                    {!! Form::select('active', $data['active'], $data['active'], array('id'=>'active','class'=>'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div style="clear: both; padding-top: 25px;"></div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              <button type="submit" id="project_save_btn" class="btn btn-primary">Save</button>
                              </form>
                            </div>
                          </div>

                        </div>
                      </div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                       <div class="dataTables_length" id="agent-table_length">
                            <form method="POST" action="{{route('projects')}}" role="sort">
                            {{ csrf_field() }}
                            <input type="hidden" name="search_by" value="{{$search_by}}">
                            <input type="hidden" name="search_text" value="{{$search_text}}">
                            <input type="hidden" value="{{$sort_by}}" name="sort_by">
                            <label>Show
                            <select name="paginate_show" aria-controls="agent-table" class="" onchange="this.form.submit()">
                            <option value="5" <?php if ($paginate_show == 5): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>5
                            </option>
                            <option value="10" <?php if ($paginate_show == 10): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>10
                            </option>
                            <option value="25" <?php if ($paginate_show == 25): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>25
                            </option>
                            <option value="50" <?php if ($paginate_show == 50): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>50
                            </option>
                            <option value="100" <?php if ($paginate_show == 100): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>100
                            </option>
                            </select> entries</label>
                            </form>
                        </div>
                        {!! Form::open(array('route' => 'projects')) !!}
                                <?php
if (count($projects) > 0) {
    ?>
                                    <div class="row">
                                        <div class="col-md-2 grid-margin">project</div>
                                        <div class="col-md-2 grid-margin">Manager</div>
                                        <div class="col-md-2 grid-margin">Project Type</div>
                                        <div class="col-md-2 grid-margin">Deadline</div>
                                        <div class="col-md-1 grid-margin">Status</div>
                                        <div class="col-md-2 grid-margin">
                                        </div>
                                    </div>
                                <?php
}
?>
                            <?php $i = 1;?>
                            @foreach ($projects as $project)

                                <div class="row <?php echo ($i == 1) ? 'grid-odd' : 'grid-even' ?>">
                                    <div class="col-md-2 grid-margin">{{ $project->project }}</div>
                                    <div class="col-md-2 grid-margin">{{ $project->manager->full_name }}</div>
                                    <div class="col-md-2 grid-margin">{{ $project->type->project_types }}</div>
                                    <div class="col-md-2 grid-margin">{{ $project->deadline }}</div>
                                    <div class="col-md-1 grid-margin">{{ $project->is_active }}</div>
                                    <div class="col-md-2 grid-margin">
                                        <a style="float: left;" href="#" project_id="{{$project->id}}" project="{{$project->project}}" manager_id="{{$project->manager_id}}" project_type="{{$project->project_type}}" deadline="{{$project->deadline}}" active="{{$project->active}}" description="{{$project->description}}" class="btn btn-default project_edit">Edit</a>&nbsp;                                       
                                    </div>
                                </div>

                                <?php
$i = ($i == 1) ? 2 : 1;
?>
                            @endforeach
                            {{ $projects->appends(array('search_by' => $search_by,'search_text'=>$search_text,'sort_by'=>$sort_by,'paginate_show'=>$paginate_show))->links() }}
                                <?php
if (count($projects) == 0) {
    ?>
                                    <h3>No projects found!  Please try again.</h3>
                                <?php
}
?>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@section('pagescript')
<script type="text/javascript">
$(function(){
    $( "#deadline" ).datepicker({
    dateFormat: "mm/dd/yy"
    });

    $('#project_valid').hide();
    $('#project_type_valid').hide();
    $('#manager_id_valid').hide();

    $('#project_save_btn').click(function(){
        var manager_id = $('#manager_id').val();
        var project_type = $('#project_type').val();
        var project = $('#project').val();

        if (manager_id=='') {
           $('#manager_id_valid').show();
           return false;
        }else{
           $('#manager_id_valid').hide();
        }

        if (project_type=='') {
           $('#project_type_valid').show();
           return false;
        }else{
           $('#project_type_valid').hide();
        }

        if (project=='') {
           $('#project_valid').show();
           return false;
        }else{
           $('#project_valid').hide();
        }


        $('form#project_form').submit();
    });

    $(".project_edit").click(function(){
     $('.pass').hide();
     $('#manager_id_valid').hide();
     $('#project_type_valid').hide();
     $('#project_valid').hide();

        $('.project_header').html("Edit Project");

        var project_id = $(this).attr('project_id');
        var manager_id = $(this).attr('manager_id');
        var project_type = $(this).attr('project_type');
        var project = $(this).attr('project');
        var description = $(this).attr('description');
        var deadline = $(this).attr('deadline');
        var active = $(this).attr('active');

        $('#project_form')[0].reset();

        $('#project_id').val(project_id);
        $('#manager_id').val(manager_id);
        $('#project_type').val(project_type);
        $('#project').val(project);
        $('#description').val(description);
        $('#deadline').val(deadline);
        $('#active').val(active);
        $('#projectModal').modal('show');
    });
    $("#add_project").click(function(){
        $('#project_form')[0].reset();
        $('#project_id').val('');
        $('.project_header').html("Add new project");
        $('#projectModal').modal('show');
    })

    $(".input-group-btn .dropdown-menu li a").click(function(){
        var selHtml = $(this).html();
       $(this).parents('.input-group-btn').find('.btn-search').html(selHtml);
       var searchtext = $(this).find(".label-icon").html();
       if (searchtext =='Project Name') {
        $('#search_by').val("project");
        //$('#school_search').hide();
        $('#search_text').show();
        $('#search_text').val('');
       }else{
        $('#search_by').val('');
        $('#search_text').val('');
        //$('#school_search').hide();
        $('#search_text').show();
       }
   });

});
</script>
@endsection
@endsection

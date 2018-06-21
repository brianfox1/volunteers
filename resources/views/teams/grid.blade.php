@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div >
                <div class="panel panel-default">

                    <div class="panel-heading">
                            <div class="row">
                            <div class="col-sm-2">
                                Team Information
                            </div>
                                <div class="col-sm-10">
                                    <div class="row team-info-wrap">
                                    <!-- <div class="col-md-2"><a href="#" id="add_team" class="btn btn-primary">Add new team</a></div> -->
<!--                                 <div class="col-md-2"><a href="{{ url('/team_export') }}" class="btn btn-default">Export</a></div> -->
                                <div class="col-md-5">

                                </div>
                                <div class="col-md-3">

                                </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="panel-body" style="min-height: 500px;">
                        <form method="POST" action="{{url('teams')}}" id="project_form" name="project_add_edit">
                        {{ csrf_field() }}  
                         <input type="hidden" name="search_by" value="project_id">                    
                        <div class='row'>
                            <div class='col-md-4'></div>

                            <div class='col-md-4'>
                                <div class="form-group">
                                    {!! Form::label('Projects') !!}
                                    {!! Form::select('search_text', $data['projects'], $data['project_id'], array('id'=>'search_text','class'=>'form-control','placeholder'=>'Plese select')) !!}
                                </div>
                                <button type="submit" id="project_save_btn" class="btn btn-primary">Search</button>
                            </div>

                            <div class='col-md-4'></div>

                        </div>                          
                        
                        </form>                                            
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @if($search_text)
                       <div class="dataTables_length" id="agent-table_length">
                            <form method="POST" action="{{route('teams')}}" role="sort">
                            {{ csrf_field() }}
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
                        {!! Form::open(array('route' => 'teams')) !!}
                                <?php
if (count($teams) > 0) {
    ?>
                                    <div class="row">
                                        <div class="col-md-4 grid-margin">Name</div>
                                        <div class="col-md-4 grid-margin">Email</div>
                                        <div class="col-md-4 grid-margin">Mobile</div>
                                    </div>
                                <?php
}
?>
                            <?php $i = 1;?>
                            @foreach ($teams as $team)

                                <div class="row <?php echo ($i == 1) ? 'grid-odd' : 'grid-even' ?>">
                                    <div class="col-md-4 grid-margin">{{ $team->user->r_full_name }}</div>
                                    <div class="col-md-4 grid-margin">{{ $team->user->email }}</div>
                                    <div class="col-md-4 grid-margin">{{ $team->user->mobile }}</div>
                                </div>

                                <?php
$i = ($i == 1) ? 2 : 1;
?>
                            @endforeach
                            {{ $teams->appends(array('search_by' => $search_by,'search_text'=>$search_text,'sort_by'=>$sort_by,'paginate_show'=>$paginate_show))->links() }}
                                <?php
if (count($teams) == 0) {
    ?>
                                    <h3>No teams found!  Please try again.</h3>
                                <?php
}
?>
                        {!! Form::close() !!}


                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@section('pagescript')
<script type="text/javascript">
$(function(){
});
</script>
@endsection
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div >
                <div class="panel panel-default">

                    <div class="panel-heading">
                            <div class="row">
                            <div class="col-sm-2">
                                User Information
                            </div>
                                <div class="col-sm-10">
                                    <div class="row user-info-wrap">
                                    <div class="col-md-2"><a href="#" id="add_user" class="btn btn-primary">Add new user</a></div>
<!--                                 <div class="col-md-2"><a href="{{ url('/user_export') }}" class="btn btn-default">Export</a></div> -->
                                <div class="col-md-5">
                                    <form method="POST" action="{{route('users')}}" class="navbar-form navbar-search" role="search" style="margin: 0;padding-left: 20px;padding-right: 0;">
                                    {{ csrf_field() }}
                                        <div class="input-group">

                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-search btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="fa fa-btn fa-search"></span>
                                                    <span class="label-icon">
                                                        <?php if ($search_by == "") {
    echo "Search By";
} else if ($search_by == "last_name") {
    echo "Last Name";
} else if ($search_by == "mobile") {
    echo "Mobile";
}else {
    echo "Email";
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
                                                            <span class="label-icon">Last Name</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="fa fa-btn fa-search"></span>
                                                        <span class="label-icon">Mobile</span>
                                                        </a>
                                                    </li>                                                    <li>
                                                        <a href="#">
                                                        <span class="fa fa-btn fa-search"></span>
                                                        <span class="label-icon">Email</span>
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
                                    <form method="POST" action="{{route('users')}}" role="sort">
                                    {{ csrf_field() }}
                                      <input type="hidden" name="search_by" value="{{$search_by}}">
                                      <input type="hidden" name="search_text" value="{{$search_text}}">
                                      <input type="hidden" name="paginate_show" value="{{$paginate_show}}">
                                      <select name="sort_by" class="form-control" id="sort_by" onchange="this.form.submit()">
                                        <option value="" <?php if ($sort_by == ''): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>Sort By</option>
                                        <option value="last_name" <?php if ($sort_by == 'last_name'): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>Last name</option>
                                        <option value="email" <?php if ($sort_by == 'email'): ?>
                                            <?php echo "selected" ?>
                                        <?php endif?>>Email</option>
                                      </select>
                                    </form>
                                </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="panel-body" style="min-height: 500px;">
                      <div class="modal fade" id="userModal" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title user_header">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{url('save_user')}}" id="user_form" name="user_add_edit">
                                {{ csrf_field() }}
                                <input type="hidden" id="user_id" name="id" value="{{ $data['id'] }}">
                                <div class='row'>
                                  <div class='col-md-6'>
                                     <div class="form-group">

                                    {!! Form::label('User Type') !!}
                                    {!! Form::select('user_level', $data['user_levels'], $data['user_level'], array('id'=>'user_level','class'=>'form-control', 'required' => 'required')) !!}
                                    </div>
                                  </div>
                                  <div class='col-md-6'>
  
                                  </div>
                                </div>
                                <div class='row'>
                                  <div class='col-md-6'>
                                     <div class="form-group">

                                    {!! Form::label('First Name') !!}
                                    {!! Form::text('first_name', $data['first_name'], array('id'=>'first_name','class'=>'form-control','required' => 'required')); !!}
                                    <p id="f_name_valid" style="margin-left: 40px; color: red;"><sub>First name is required</sub></p>
                                    </div>
                                  </div>
                                  <div class='col-md-6'>
                                    <div class="form-group">
                                    {!! Form::label('Last Name') !!}
                                    {!! Form::text('last_name', $data['last_name'], array('id'=>'last_name','class'=>'form-control','required' => 'required')); !!}
                                    <p id="l_name_valid" style="margin-left: 40px; color: red;"><sub>Last name is required</sub></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">

                                    {!! Form::label('Email') !!}
                                    {!! Form::text('email', $data['email'], array('id'=>'email','class'=>'form-control','size' => 100, 'required' => 'required')); !!}
                                    <p style="margin-left: 40px;"><sub>Email Address is also Username</sub></p>
                                    <p  id="email_valid" style="margin-left: 40px; color: red;"><sub>Email Id is invalide or empty</sub></p>
                                </div>
                                <div class='row'>
                                  <div class='col-md-4'>
                                     <div class="form-group">

                                    {!! Form::label('mobile') !!}
                                    {!! Form::text('mobile', $data['mobile'], array('id'=>'mask-mobile-number','minlength'=>'13','class'=>'form-control','placeholder'=>"(XXX)XXX-XXXX")); !!}
                                    <p  id="m_no_valid" style="margin-left: 40px; color: red;"><sub>Invalid mobile number</sub></p>
                                    </div>
                                  </div>
                                  <div class='col-md-4'>
                                     <div class="form-group">

                                    {!! Form::label('Mobile Notification') !!}
                                    {!! Form::select('mobile_notifications', $data['mobile_notifications'], $data['mobile_notifications'], array('id'=>'mobile_notifications','class'=>'form-control','placeholder' => 'Please Select', 'required' => 'required')) !!}
                                    </div>
                                  </div>
                                  <div class='col-md-4'>
                                     <div class="form-group">

                                    {!! Form::label('Mobile Carrier') !!}
                                    {!! Form::select('mobile_carrier', $data['mobile_carrier'], null, array('id'=>'mobile_carrier','class'=>'form-control','placeholder' => 'Please Select', 'required' => 'required')) !!}
                                    </div>
                                  </div>
                                </div>
                                <div class='row'>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>


                                            <input id="password" type="password" class="form-control" name="password" value="" <?php echo (!isset($data['id'])) ? 'required="required"' : '' ?>>
                                            <p  id="password_valid" style="margin-left: 40px; color: red;"><sub>Password is required</sub></p>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>


                                <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    {!! Form::label('Confirm Password') !!}

                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="" <?php echo (!isset($data['id'])) ? 'required="required"' : '' ?>>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                        <span class="help-block pass" style="color:red">
                                            <strong>Password and password confirmation must match!</strong>
                                        </span>
                                </div>
                                </div>
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
                              <button type="submit" id="user_save_btn" class="btn btn-primary">Save</button>
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
                            <form method="POST" action="{{route('users')}}" role="sort">
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
                        {!! Form::open(array('route' => 'users')) !!}
                                <?php
if (count($users) > 0) {
    ?>
                                    <div class="row">
                                        <div class="col-md-2 grid-margin">User</div>
                                        <div class="col-md-2 grid-margin">User level</div>
                                        <div class="col-md-2 grid-margin">Mobile</div>
                                        <div class="col-md-3 grid-margin">Email</div>
                                        <div class="col-md-2 grid-margin">
                                        </div>
                                    </div>
                                <?php
}
?>
                            <?php $i = 1;?>
                            @foreach ($users as $user)

                                <div class="row <?php echo ($i == 1) ? 'grid-odd' : 'grid-even' ?>">
                                    <div class="col-md-2 grid-margin">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="col-md-2 grid-margin">{{ $user->level }}</div>
                                    <div class="col-md-2 grid-margin">{{ $user->mobile }}</div>
                                    <div class="col-md-3 grid-margin"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                                    <div class="col-md-2 grid-margin">
                                        @if($data['current_user_id'] != $user->id)
                                        <a style="float: left;" href="#" user_id="{{$user->id}}" first_name="{{$user->first_name}}" last_name="{{$user->last_name}}" mobile="{{$user->mobile}}" email="{{$user->email}}" mobile="{{$user->mobile}}" user_level="{{$user->user_level}}" mobile_carrier="{{$user->mobile_carrier}}" mobile_notifications="{{$user->mobile_notifications}}" active="{{$user->active}}" school_id="{{$user->school_id}}" class="btn btn-default user_edit">Edit</a>&nbsp;                                       
                                        <a href="{{ url('/user_login_by_id/' . $user->id) }}" class="btn btn-default">Login</a>
                                        @endif
                                    </div>
                                </div>

                                <?php
$i = ($i == 1) ? 2 : 1;
?>
                            @endforeach
                            {{ $users->appends(array('search_by' => $search_by,'search_text'=>$search_text,'sort_by'=>$sort_by,'paginate_show'=>$paginate_show))->links() }}
                                <?php
if (count($users) == 0) {
    ?>
                                    <h3>No Users found!  Please try again.</h3>
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
     $('.pass').hide();
     $('#f_name_valid').hide();
     $('#l_name_valid').hide();
     $('#m_no_valid').hide();
     $('#email_valid').hide();
     $('#password_valid').hide();
     //$('#school_search').hide();
     $("#mask-mobile-number").mask("(999)999-9999"); 

     $('#mobile_notifications').change(function(){
        var mobile_notifications= $(this).val();

        if (mobile_notifications =='Y') {
           $('#mobile_carrier').prop('disabled',false);
        }else{
           $('#mobile_carrier').prop('disabled',true);
        }
     });
    $('#user_save_btn').click(function(){
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var mobile = $('#mask-mobile-number').val();
        var email = $('#email').val();
        var user_id = $('#user_id').val();
        var password = $('#password').val();
        var user_level = $("#user_level option:selected").text();

        if (first_name=='') {
           $('#f_name_valid').show();
           return false;
        }else{
           $('#f_name_valid').hide();
        }

        if (last_name=='') {
           $('#l_name_valid').show();
           return false;
        }else{
           $('#l_name_valid').hide();
        }

        if (mobile=='' || mobile.length < 13) {
           $('#m_no_valid').show();
           return false;
        }else{
           $('#m_no_valid').hide();
        }

        if (!validateEmail(email) || email=='') {
           $('#email_valid').show();
           return false;
        }else{
           $('#email_valid').hide();
        }

        if (user_id=='') {
            if (password=='') {
               $('#password_valid').show();
               return false;
            }else{
               $('#password_valid').hide();
            }
        }
        $('form#user_form').submit();
    });

    function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }
    $("#password_confirmation").change(function(){
        if ($('#password').val() && $('#password_confirmation').val()) {
            if ($('#password_confirmation').val() == $('#password').val()) {
               $('#user_save_btn').prop('disabled', false);
               $('.pass').hide();
               $('#password_valid').hide();
            }else{
                $('#user_save_btn').prop('disabled', true);
                $('.pass').show();
            }
        }else{
            if (!$('#password').val() && !$('#password_confirmation').val()) {
                $('#user_save_btn').prop('disabled', false);
                $('.pass').hide();
                $('#password_valid').hide();
            }else{
                $('#user_save_btn').prop('disabled', true);
                $('.pass').show();
            }
        }
    });
    $("#password").change(function(){
        if ($('#password').val() && $('#password_confirmation').val()) {
            if ($('#password_confirmation').val() == $('#password').val()) {
               $('#user_save_btn').prop('disabled', false);
               $('.pass').hide();
               $('#password_valid').hide();
            }else{
                $('#user_save_btn').prop('disabled', true);
                $('.pass').show();
            }
        }else{
            if (!$('#password').val() && !$('#password_confirmation').val()) {
                $('#user_save_btn').prop('disabled', false);
                $('.pass').hide();
                $('#password_valid').hide();
            }else{
                $('#user_save_btn').prop('disabled', true);
                $('.pass').show();
            }

        }
    });
    $(".user_edit").click(function(){
     $('.pass').hide();
     $('#f_name_valid').hide();
     $('#l_name_valid').hide();
     $('#m_no_valid').hide();
     $('#email_valid').hide();
     $('#password_valid').hide();

        $('.user_header').html("Edit User");

        var user_id = $(this).attr('user_id');
        var first_name = $(this).attr('first_name');
        var last_name = $(this).attr('last_name');
        var email = $(this).attr('email');
        var mobile = $(this).attr('mobile');
        var mobile_carrier = $(this).attr('mobile_carrier');
        var user_level = $(this).attr('user_level');
        var active = $(this).attr('active');
        var mobile_notifications = $(this).attr('mobile_notifications');

        if (mobile_notifications == 'N') {
          $('#mobile_carrier').prop('disabled',true);
        }

        $('#user_form')[0].reset();

        $('#first_name').val(first_name);
        $('#user_id').val(user_id);
        $('#last_name').val(last_name);
        $('#email').val(email);
        $('#mask-mobile-number').val(mobile);
        $('#mobile_carrier').val(mobile_carrier);
        $('#user_level').val(user_level);
        $('#active').val(active);
        $('#mobile_notifications').val(mobile_notifications);
        $('#userModal').modal('show');
    });
    $("#add_user").click(function(){
        $('#user_form')[0].reset();
        $('#user_id').val('');
        $('.user_header').html("Add new user");
        $('#userModal').modal('show');
    })

    $(".input-group-btn .dropdown-menu li a").click(function(){
        var selHtml = $(this).html();
       $(this).parents('.input-group-btn').find('.btn-search').html(selHtml);
       var searchtext = $(this).find(".label-icon").html();
       if (searchtext =='Last Name') {
        $('#search_by').val("last_name");
        //$('#school_search').hide();
        $('#search_text').show();
        $('#search_text').val('');
       }else if(searchtext=='Mobile'){
        $('#search_by').val('mobile');
        //$('#school_search').hide();
        $('#search_text').show();
        $('#search_text').val('');
       }else if(searchtext=='Email'){
        $('#search_by').val('email');
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

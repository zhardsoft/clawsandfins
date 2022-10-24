@extends('layouts.master')

@section('menu')
    @include('components.admin-menu')
@endsection

@section('body_class')
page-no-arc
@endsection

@section('content')
        <!-- Content -->
        <div class="content-wrapper">
            <section class="section" data-clip-id="1" style="background-image: url('{{asset('bg/grey4.jpg')}}');">
                <div class="content">
                    <div class="full-width align-in-center pb-120">
                        <div class="_75-width md_90-width md_align-center flex-column justify-center max-w700">
                            <div class="full-width">
                                <h1 class="h1 text-yellow sm_font-size-35 sm_mt-60 text-center">Manage Users</h1>
                                <div class="form-container">
                                    <div class="d-flex full-width justify-between align-center">
                                        <p class="text-light">Showing out of {{count($users)}} users</p>
                                        <div class="button-secondary">
                                            <a href="{{ route('users.create') }}"><button>Add User</button></a>
                                        </div>
                                    </div>
                                    <div class="table-header d-flex">
                                        <div class="equal-width">User</div>
                                        <div class="equal-width">Role</div>
                                        <div class="equal-width">Status</div>
                                    </div>
                                    @foreach($users as $user)
                                        <div class="table-row d-flex">
                                            <div class="equal-width">
                                                <div class="d-flex">
                                                    <div><span class="user-avatar">{{Str::upper(substr($user->name, 0, 1))}}</span></div>
                                                    <div class="flex-column">
                                                        <span>{{$user->name}}</span>
                                                        <span class="font-size-12 text-light">{{$user->email}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="equal-width">
                                                @foreach($user->roles as $role)
                                                    <span class="font-size-12 text-light">{{$role->name}}</span>
                                                @endforeach
                                            </div>
                                            <div class="equal-width d-flex">
                                                <div class="equal-width">
                                                    @if ($user->status == 1)
                                                        <span class="font-size-12 text-light">Approved</span>
                                                    @else
                                                        <span class="font-size-12 text-light">Pending</span>
                                                    @endif
                                                </div>
                                                <div class="more-menu">
                                                    <button onclick="openContextMenu($(this).parent())">
                                                        <span class="material-icons">
                                                            more_vert
                                                        </span>
                                                    </button>
                                                    <div class="context-menu">
                                                        <ul>
                                                            <li class="context-menu-item">Approved</li>
                                                            <li class="context-menu-item">Reject</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>
                                <div class="d-flex">
                                    {!! $users->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

@endsection

@section('style_extra')
<style>
    .logo {
            background-color: rgba(255, 255, 255, 0.1);
            width: 150px;
            height: 150px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .logo img {
            display: none;
        }

        .logo span {
            font-size: 45px;
            color: white;
        }

        .logo+button {
            display: none;
            margin-top: 20px;
            background: transparent;
            border: 1px solid #FFF;
            color: #FFF;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logo.image-opened {
            background: #585858;
            border: 0;
            width: 150px;
            height: 150px;
            flex-direction: column;
            margin-bottom: 0px;
            overflow: hidden;
        }

        .logo.image-opened img {
            display: block;
        }

        .logo.image-opened span {
            display: none;
        }

        .logo.image-opened+button {
            display: block;
        }

        .visiting-address {
            height: 300px;
        }

        .visiting-address #map {
            height: 100%;
        }

        .map-marker-label {
            display: block;
            border-radius: 5px;
            padding: 2px 8px;
        }

        .currency-field {
            position: relative;
        }

        .currency-field:before {
            content: attr(prefix);
            position: absolute;
            left: 10px;
            top: calc(50% - 1px);
            transform: translatey(-50%);
            color: #c8c8c8;
            font-size: 14px;
        }

        .currency-field input {
            padding-left: 45px;
        }

        .form-container {
            background: #4b4b4b;
        }

        .table-header{
            color: #FFF;
            font-size: 12px;
            padding: 5px 10px;
            border-bottom: 1px solid #6f6f6f;
        }

        .table-row{
            color: #FFF;
            font-size: 14px;
            padding: 10px;
            border-bottom: 1px solid #6f6f6f;
        }

        .user-avatar{
            display: block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #312f2b;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
        }

        .more-menu{
            position: relative;
        }

        .more-menu button{
            background: transparent;
            border: 0;
            color: #d1d1d1;
            cursor: pointer;
        }

        .context-menu{
            visibility: hidden;
            position: absolute;
            background: #FFF;
            top: 0;
            left: 0;
            color: #2d2d2d;
            border-radius: 5px;
            z-index: 1;
        }

        .context-menu ul{
            padding: 5px 0;
        }

        .context-menu ul li{
            padding: 5px 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .context-menu ul li:hover{
            background: #eae9e9;
        }

        .open-context-menu{
            outline: none;
        }

        .open-context-menu:focus .context-menu{
            visibility: visible;
        }
</style>
@endsection

@section('head_extra')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endsection
@section('script_extra')
<!-- Temporary Script for Logged in User >>> -->
<script>
    if (Cookies.get('logged-in')) {
        $('.distributor-investor-menu').removeClass('display-none');
        $('.distributor-investor-menu').nextAll().hide();
        $('.distributor-investor-menu').show();
        $('.login-menu').hide();
        $('.logout-menu').show();
        $('.nav-visitor').addClass('display-none');
        $('.nav-distributor-investor').removeClass('display-none');
    }
</script>


<script>
    function openContextMenu(elm){
        elm.addClass('open-context-menu').attr('tabindex','-1').focus();
        elm.find('.context-menu .context-menu-item').click(function(e){
            e.stopPropagation();
            elm.removeClass('open-context-menu');
        })
    }
</script>
<script>
function inputValidation(form) {
    var errMsgCount = 0;
    $(form).find('.input-text[required] input, .input-textarea[required] textarea').each(function () {
        var elm = $(this);
        var parentElm = elm.attr('parent') ? elm.parents(elm.attr('parent')) : elm.parent();
        if (elm.val() == '') {
            errMsgCount++;
            parentElm.addClass('input-error');
            if (parentElm.find('.err-msg').length == 0) {
                var inpErr = document.createElement('span');
                $(inpErr).addClass('err-msg').html('Required');
                parentElm.append(inpErr);
            }
            elm.keyup(function () {
                $(this).parents('.input-error').removeClass('input-error');
                $(this).next('.err-msg').remove();
            })
            if (errMsgCount == 1) {
                elm.focus();
            }

        }

        if (($('#password').val() != $('#confirm-password').val()) && errMsgCount == 0) {
            openDialog('Password', "Password doesn't match");
            $('#password').focus();
            errMsgCount++;
        }
    })

    if (errMsgCount > 0) {
        return false;
    }

    return true;
}
</script>
<!-- >>> End -->
@endsection
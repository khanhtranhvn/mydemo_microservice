<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 12/23/17
 * Time: 22:32
 */
?>
@extends('layouts.default')
@section('content')
    <div class="text-center" style="padding:50px 0">
        <div class="logo">login</div>
        <!-- Main Form -->
        <div class="login-form-1">
            <form id="login-form" class="text-left">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                    <div class="login-group">
                        <div class="form-group">
                            <label for="lg_username" class="sr-only">Email</label>
                            <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="lg_password" class="sr-only">Password</label>
                            <input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="password">
                        </div>
                    </div>
                    <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="etc-login-form">
                    <p>new user? <a href="#">create new account</a></p>
                </div>
            </form>
        </div>
        <!-- end:Main Form -->
    </div>

@stop

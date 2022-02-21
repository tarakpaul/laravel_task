<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/js/uikit-icons.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
    <header>       
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left" id="div1">
                <ul class="uk-navbar-nav">
                    <li class="uk-text-bold{{ (request()->is('/')) ? ' uk-active' : '' }}" >
                        <a href="/">DASH BOARD</a>
                    </li>
                    <li class="uk-text-bold {{ (request()->is('user')) ? ' uk-active' : '' }}">
                        <a  href="user">USER</a>
                    </li>
                    <li class="uk-text-bold {{ (request()->is('state')) ? ' uk-active' : '' }}">
                        <a href="state">STATE</a>
                    </li>
                     <li class="uk-text-bold">
                        <a href="logout" class="uk-text-danger">Log out</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>



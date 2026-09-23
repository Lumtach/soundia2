@extends('layouts.soundia')
@section('content')
<main class="portfolio-page"><h1 class="visually-hidden">Portfolio</h1>@include('partials.portfolio-list', ['projects' => $content['projects']])</main>
@endsection

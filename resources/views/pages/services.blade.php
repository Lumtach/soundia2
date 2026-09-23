@extends('layouts.soundia')
@section('content')
<main class="services-page">
@include('partials.services-section', ['copy' => ['label' => preg_replace('/^\d+\s*\/\s*/', '', $dict['home']['services']['label']), 'headline' => $dict['home']['services']['headline']], 'services' => $content['services']])
</main>
@endsection

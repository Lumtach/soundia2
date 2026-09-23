@extends('layouts.soundia')
@section('content')
@php($prices = [
 ['id'=>'guide','title'=>['ru'=>'Аудиогид','lv'=>'Audiogids','en'=>'Audio guide'],'description'=>['ru'=>'Сценарий, запись, монтаж и подготовка к запуску.','lv'=>'Scenārijs, ieraksts, montāža un sagatavošana palaišanai.','en'=>'Script, recording, editing and launch preparation.'],'price'=>'от €800'],
 ['id'=>'quest','title'=>['ru'=>'Аудиоквест','lv'=>'Audiokvests','en'=>'Audio quest'],'description'=>['ru'=>'Интерактивный маршрут с драматургией и звуковой средой.','lv'=>'Interaktīvs maršruts ar dramaturģiju un skaņas vidi.','en'=>'Interactive route with dramaturgy and sound design.'],'price'=>'от €990'],
 ['id'=>'spatial','title'=>['ru'=>'3D Audio','lv'=>'3D Audio','en'=>'3D Audio'],'description'=>['ru'=>'Пространственный звук для иммерсивных культурных проектов.','lv'=>'Telpiska skaņa imersīviem kultūras projektiem.','en'=>'Spatial sound for immersive cultural projects.'],'price'=>'от €2500'],
 ['id'=>'promenade','title'=>['ru'=>'Promenade','lv'=>'Promenade','en'=>'Promenade'],'description'=>['ru'=>'Звуковой спектакль или прогулка для города, музея или события.','lv'=>'Skaņas izrāde vai pastaiga pilsētai, muzejam vai notikumam.','en'=>'Sound performance or walk for a city, museum or event.'],'price'=>'от €3000']
])
<main class="pricing-page">@include('partials.pricing-section', ['copy' => $dict['home']['pricing'], 'prices' => $prices])</main>
@endsection

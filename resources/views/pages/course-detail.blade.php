@extends('layouts.soundia')
@section('content')
@php
$copy = [
  'ru' => ['back' => '← Все курсы', 'enrollCourse' => 'Записаться на курс', 'learn' => 'Вы научитесь', 'audience' => 'Кому подойдёт', 'result' => 'Результат'],
  'lv' => ['back' => '← Visi kursi', 'enrollCourse' => 'Pieteikties kursam', 'learn' => 'Jūs iemācīsieties', 'audience' => 'Kam piemērots', 'result' => 'Rezultāts'],
  'en' => ['back' => '← All courses', 'enrollCourse' => 'Enroll in course', 'learn' => 'You will learn', 'audience' => 'Who it is for', 'result' => 'Result'],
][$locale];

$courses = [
  'sound-design' => [
    'title' => ['ru'=>'Основы звукового дизайна и аудиопостобработки','lv'=>'Skaņas dizaina pamati un audio pēcapstrāde','en'=>'Sound Design and Audio Post-Production Basics'],
    'meta' => ['ru'=>'72 часа · очно','lv'=>'72 stundas · klātienē','en'=>'72 hours · in person'],
    'lead' => ['ru'=>'Научитесь работать со звуком — от записи до готового аудиопроекта.','lv'=>'Iemācieties strādāt ar skaņu — no ieraksta līdz gatavam audioprojektam.','en'=>'Learn to work with sound, from recording to a finished audio project.'],
    'description' => ['ru'=>'Практический курс для тех, кто хочет освоить запись, монтаж, обработку и сведение звука. Начнём с основ работы в DAW и постепенно перейдём к созданию собственного проекта.','lv'=>'Praktisks kurss tiem, kas vēlas apgūt skaņas ierakstu, montāžu, apstrādi un miksēšanu. Sāksim ar DAW pamatiem un pakāpeniski nonāksim līdz savam projektam.','en'=>'A practical course for anyone who wants to master recording, editing, processing and mixing audio. We start with DAW basics and move toward your own complete project.'],
    'tags' => ['ru'=>['DAW','EQ','Компрессия','Мастеринг'], 'lv'=>['DAW','EQ','Kompresija','Māsterings'], 'en'=>['DAW','EQ','Compression','Mastering']],
    'learn' => ['ru'=>['Записывать и редактировать звук','Работать с EQ, компрессией, реверберацией и эффектами','Очищать аудио от шумов и выполнять полевые записи','Сводить материал и понимать основы мастеринга'], 'lv'=>['Ierakstīt un rediģēt skaņu','Strādāt ar EQ, kompresiju, reverbu un efektiem','Tīrīt trokšņus un veidot lauka ierakstus','Miksēt materiālu un saprast māsteringa pamatus'], 'en'=>['Record and edit sound','Use EQ, compression, reverb and effects','Clean noise and make field recordings','Mix material and understand mastering basics']],
    'audience' => ['ru'=>'Начинающим, подкастерам, музыкантам, создателям видео и всем, кто хочет уверенно работать со звуком.','lv'=>'Iesācējiem, podkāstu veidotājiem, mūziķiem, video autoriem un visiem, kas vēlas droši strādāt ar skaņu.','en'=>'For beginners, podcasters, musicians, video creators and anyone who wants to work confidently with sound.'],
    'result' => ['ru'=>'К концу курса вы самостоятельно создадите законченный аудиопроект и получите свидетельство о прохождении программы.','lv'=>'Kursa beigās jūs patstāvīgi izveidosiet gatavu audioprojektu un saņemsiet apliecību par programmas apguvi.','en'=>'By the end, you will create a finished audio project and receive a certificate of completion.'],
    'syllabus' => [
      'eyebrow'=>['ru'=>'Цель программы','lv'=>'Programmas mērķis','en'=>'Program goal'],
      'title'=>['ru'=>'Практическая программа по саунд-дизайну, записи, монтажу, реставрации, сведению и подготовке финального материала.','lv'=>'Praktiska programma darbam ar skaņas dizainu, ierakstu, montāžu, restaurāciju, miksēšanu un gala materiāla sagatavošanu.','en'=>'A practical program for sound design, recording, editing, restoration, mixing and final audio material preparation.'],
      'intro'=>['ru'=>['Программа рассчитана на участников без предыдущего профессионального опыта. Нужны базовые навыки работы с компьютером.','В практической работе участник осваивает полный цикл аудиопостобработки и разрабатывает свой проект.'], 'lv'=>['Programma paredzēta interesentiem bez iepriekšējas profesionālās pieredzes. Nepieciešamas datora lietošanas pamatprasmes.','Praktiskajā darbā dalībnieks apgūst pilnu skaņas pēcapstrādes plūsmu un izstrādā savu projektu.'], 'en'=>['The program is designed for participants without previous professional experience. Basic computer skills are required.','Through practical work, participants learn the full audio post-production flow and develop their own final project.']],
      'modulesEyebrow'=>['ru'=>'Что освоите','lv'=>'Ko apgūsiet','en'=>'What you will learn'],
      'modules'=>['ru'=>['Введение в саунд-дизайн и работу с DAW','Монтаж и редактирование аудиоматериала','Основы записи звука','Аудиоэффекты и обработка сигнала','Практическое создание звуковых эффектов','Основы сведения','Полевые записи','Аудиореставрация и мастеринг','Финальный проект и оценивание'], 'lv'=>['Ievads skaņas dizainā un darbs ar DAW','Audio materiāla montāža un rediģēšana','Skaņas ieraksta pamati','Audio efekti un signāla apstrāde','Praktiska skaņas efektu veidošana','Miksēšanas pamati','Lauka ieraksts','Audio restaurācija un māsterings','Noslēguma projekts un vērtēšana'], 'en'=>['Introduction to sound design and DAW workflow','Audio material editing and arrangement','Sound recording basics','Audio effects and signal processing','Practical sound effect creation','Mixing basics','Field recording','Audio restoration and mastering','Final project and assessment']],
      'volumeEyebrow'=>['ru'=>'Объём программы','lv'=>'Programmas apjoms','en'=>'Program volume'],
      'hours'=>['ru'=>[['Теория','16 ч'],['Практика','48 ч'],['Оценивание','8 ч']], 'lv'=>[['teorija','16 h'],['prakse','48 h'],['vērtēšana','8 h']], 'en'=>[['Theory','16 h'],['Practice','48 h'],['Assessment','8 h']]],
      'total'=>['ru'=>['Всего','72 ч'], 'lv'=>['Kopā','72 h'], 'en'=>['Total','72 h']],
    ],
  ],
  'voice-recording' => [
    'title' => ['ru'=>'Основы записи голоса и аудиопостобработки','lv'=>'Balss ieraksta un audiopēcapstrādes pamati','en'=>'Voice Recording and Audio Post-Production Basics'],
    'meta' => ['ru'=>'24 часа · очно','lv'=>'24 stundas · klātienē','en'=>'24 hours · in person'],
    'lead' => ['ru'=>'Сделайте так, чтобы голос звучал чисто, понятно и профессионально.','lv'=>'Panāciet, lai balss ierakstā skan tīri, saprotami un profesionāli.','en'=>'Make recorded voice sound clean, clear and professional.'],
    'description' => ['ru'=>'Короткий практический курс по записи и обработке речи для подкастов, интервью, voice-over, видео и другого цифрового контента.','lv'=>'Īss praktisks kurss par runas ierakstu un apstrādi podkāstiem, intervijām, voice-over, video un citam digitālam saturam.','en'=>'A short practical course on recording and processing speech for podcasts, interviews, voice-over, video and other digital content.'],
    'tags' => ['ru'=>['Голос','Монтаж','Шум','Публикация'], 'lv'=>['Balss','Montāža','Troksnis','Publicēšana'], 'en'=>['Voice','Editing','Noise','Publishing']],
    'learn' => ['ru'=>['Правильно записывать голос','Монтировать речь, ошибки и паузы','Выравнивать громкость и использовать EQ/компрессию','Убирать фоновый шум и готовить аудио к публикации'], 'lv'=>['Pareizi ierakstīt balsi','Montēt runu, kļūdas un pauzes','Līdzināt skaļumu un izmantot EQ/kompresiju','Tīrīt fona troksni un sagatavot audio publicēšanai'], 'en'=>['Record voice correctly','Edit speech, mistakes and pauses','Balance loudness and use EQ/compression','Remove background noise and prepare audio for publishing']],
    'audience' => ['ru'=>'Подкастерам, блогерам, авторам видео, дикторам, создателям интервью и всем, кто регулярно работает с речью.','lv'=>'Podkāstu veidotājiem, blogeriem, video autoriem, diktoriem, interviju veidotājiem un visiem, kas regulāri strādā ar runu.','en'=>'For podcasters, bloggers, video creators, voice artists, interview makers and anyone who regularly works with speech.'],
    'result' => ['ru'=>'В конце курса вы создадите голосовой проект: фрагмент подкаста, интервью или voice-over.','lv'=>'Kursa beigās jūs izveidosiet balss projektu: podkāsta fragmentu, interviju vai voice-over.','en'=>'By the end, you will create a voice project: a podcast segment, interview or voice-over.'],
    'syllabus' => [
      'eyebrow'=>['ru'=>'Цель программы','lv'=>'Programmas mērķis','en'=>'Program goal'],
      'title'=>['ru'=>'Сфокусированный практический курс по качественной записи голоса, обработке и подготовке финального материала.','lv'=>'Koncentrēts praktisks kurss kvalitatīvam balss ierakstam, apstrādei un gala materiāla sagatavošanai.','en'=>'A focused practical course for quality voice recording, processing and final material preparation.'],
      'intro'=>['ru'=>['Программа помогает освоить техническую подготовку записи голоса, работу с DAW, обработку речи и продюсирование записи до готового результата.','Обучение проходит очно на латышском языке; по договорённости возможны также русский или английский язык.'], 'lv'=>['Programma palīdz apgūt balss ieraksta tehnisko sagatavošanu, darbu ar DAW, balss apstrādes rīkiem un ieraksta producēšanu līdz gatavam rezultātam.','Mācības notiek klātienē latviešu valodā; pēc vienošanās iespējamas arī krievu vai angļu valodā.'], 'en'=>['The program helps you learn technical preparation for voice recording, DAW workflows, voice processing tools and recording production through to a finished result.','Classes take place in person in Latvian; Russian or English can be arranged by agreement.']],
      'modulesEyebrow'=>['ru'=>'Что освоите','lv'=>'Ko apgūsiet','en'=>'What you will learn'],
      'modules'=>['ru'=>['Введение в аудиопостобработку и работу с DAW','Эффекты обработки голоса и их практическое применение','Подготовка и проведение записи голоса','Продюсирование записи, финальная обработка и оценивание'], 'lv'=>['Ievads audio pēcapstrādē un darbs ar DAW','Balss apstrādes efekti un to praktiska izmantošana','Balss ieraksta sagatavošana un veikšana','Ieraksta producēšana, gala apstrāde un vērtēšana'], 'en'=>['Introduction to audio post-production and DAW workflow','Voice processing effects and practical use','Voice recording preparation and performance','Recording production, final processing and assessment']],
      'volumeEyebrow'=>['ru'=>'Объём программы','lv'=>'Programmas apjoms','en'=>'Program volume'],
      'hours'=>['ru'=>[['Теория','8 ч'],['Практика','12 ч'],['Оценивание','4 ч']], 'lv'=>[['teorija','8 h'],['prakse','12 h'],['vērtēšana','4 h']], 'en'=>[['Theory','8 h'],['Practice','12 h'],['Assessment','4 h']]],
      'total'=>['ru'=>['Всего','24 ч'], 'lv'=>['Kopā','24 h'], 'en'=>['Total','24 h']],
    ],
  ],
  'music-production' => [
    'title' => ['ru'=>'Аудиопродакшн и постобработка музыки','lv'=>'Audio producēšana un mūzikas pēcapstrāde','en'=>'Audio Production and Music Post-Production'],
    'meta' => ['ru'=>'72 часа · очно','lv'=>'72 stundas · klātienē','en'=>'72 hours · in person'],
    'lead' => ['ru'=>'Создавайте музыку от идеи до финального мастера.','lv'=>'Veidojiet mūziku no idejas līdz fināla māsteram.','en'=>'Create music from first idea to final master.'],
    'description' => ['ru'=>'Углублённый практический курс по музыкальному и аудиопродакшну: DAW, MIDI, виртуальные инструменты, композиция, запись, обработка, сведение и мастеринг.','lv'=>'Padziļināts praktisks kurss mūzikas un audioprodukcijā: DAW, MIDI, virtuālie instrumenti, kompozīcija, ieraksts, apstrāde, miksēšana un māsterings.','en'=>'An advanced practical course in music and audio production: DAW, MIDI, virtual instruments, composition, recording, processing, mixing and mastering.'],
    'tags' => ['ru'=>['MIDI','Сведение','Production','Master'], 'lv'=>['MIDI','Miksēšana','Production','Master'], 'en'=>['MIDI','Mixing','Production','Master']],
    'learn' => ['ru'=>['Работать с MIDI и виртуальными инструментами','Создавать композиции и записывать музыку','Строить цепочки эффектов и улучшать микс','Выполнять финальный мастеринг'], 'lv'=>['Strādāt ar MIDI un virtuālajiem instrumentiem','Veidot kompozīcijas un ierakstīt mūziku','Būvēt efektu ķēdes un uzlabot miksu','Veikt fināla māsteringu'], 'en'=>['Work with MIDI and virtual instruments','Create compositions and record music','Build effect chains and improve the mix','Do final mastering']],
    'audience' => ['ru'=>'Музыкантам, начинающим продюсерам и специалистам творческих индустрий. Желательно базовое понимание записи и обработки звука.','lv'=>'Mūziķiem, topošajiem producentiem un radošo industriju speciālistiem. Vēlama pamata izpratne par skaņas ierakstu un apstrādi.','en'=>'For musicians, emerging producers and creative industry specialists. Basic understanding of recording and audio processing is recommended.'],
    'result' => ['ru'=>'Во время курса вы создадите проект полного цикла: от идеи и записи до готового микса и мастера.','lv'=>'Kursa laikā jūs izveidosiet pilna cikla projektu: no idejas un ieraksta līdz gatavam miksam un māsteram.','en'=>'During the course, you will create a full-cycle project: from idea and recording to a finished mix and master.'],
    'syllabus' => [
      'eyebrow'=>['ru'=>'Цель программы','lv'=>'Programmas mērķis','en'=>'Program goal'],
      'title'=>['ru'=>'Углублённая программа по музыкальному продакшну, MIDI, записи, сведению, мастерингу и разработке финального проекта.','lv'=>'Padziļināta programma mūzikas producēšanai, MIDI, ierakstam, miksēšanai, māsteringam un noslēguma projekta izstrādei.','en'=>'An advanced program for music production, MIDI, recording, mixing, mastering and final project development.'],
      'intro'=>['ru'=>['Углублённый курс для участников, которые хотят системно развить навыки аудиопродакшна и музыкальной постобработки.','Обучение проходит очно на латышском языке; по договорённости возможны также русский или английский язык.'], 'lv'=>['Padziļināts kurss dalībniekiem, kuri vēlas sistemātiski attīstīt audio producēšanas un mūzikas pēcapstrādes prasmes.','Mācības notiek klātienē latviešu valodā; pēc vienošanās iespējamas arī krievu vai angļu valodā.'], 'en'=>['An advanced course for participants who want to systematically develop audio production and music post-production skills.','Classes take place in person in Latvian; Russian or English can be arranged by agreement.']],
      'modulesEyebrow'=>['ru'=>'Что освоите','lv'=>'Ko apgūsiet','en'=>'What you will learn'],
      'modules'=>['ru'=>['Углублённая работа с DAW','Аудиомонтаж и редактирование','MIDI-технологии и аранжировка','Основы музыкальной теории для продюсера','Эффекты и обработка сигнала','Продюсирование записи','Сведение','Мастеринг','Финальный проект и оценивание'], 'lv'=>['Padziļināts darbs ar DAW','Audio montāža un rediģēšana','MIDI tehnoloģijas un aranžēšana','Mūzikas teorijas pamati producentam','Efekti un signāla apstrāde','Ieraksta producēšana','Miksēšana','Māsterings','Noslēguma projekts un vērtēšana'], 'en'=>['Advanced DAW workflow','Audio editing and arrangement','MIDI technologies and arranging','Music theory basics for producers','Effects and signal processing','Recording production','Mixing','Mastering','Final project and assessment']],
      'volumeEyebrow'=>['ru'=>'Объём программы','lv'=>'Programmas apjoms','en'=>'Program volume'],
      'hours'=>['ru'=>[['Теория','24 ч'],['Практика','40 ч'],['Оценивание','8 ч']], 'lv'=>[['teorija','24 h'],['prakse','40 h'],['vērtēšana','8 h']], 'en'=>[['Theory','24 h'],['Practice','40 h'],['Assessment','8 h']]],
      'total'=>['ru'=>['Всего','72 ч'], 'lv'=>['Kopā','72 h'], 'en'=>['Total','72 h']],
    ],
  ],
];

$course = $courses[$slug] ?? null;
abort_unless($course, 404);
$syllabus = $course['syllabus'] ?? null;
@endphp
<main class="course-detail-page">
  <section class="course-detail-hero">
    <div class="container">
      <a class="course-detail-hero__back" href="{{ url('/courses') }}">{{ $copy['back'] }}</a>
      <p class="course-detail-hero__meta">{{ $course['meta'][$locale] }}</p>
      <h1>{{ $course['title'][$locale] }}</h1>
      <p>{{ $course['lead'][$locale] }}</p>
      <button class="course-detail-hero__button" type="button" data-modal-open="order-modal">{{ $copy['enrollCourse'] }}</button>
    </div>
  </section>

  @if($syllabus)
    <section class="course-program" aria-label="{{ $course['title'][$locale] }}">
      <div class="container course-program__layout">
        <div class="course-program__main">
          <p class="course-program__eyebrow">{{ $syllabus['eyebrow'][$locale] }}</p>
          <h2>{{ $syllabus['title'][$locale] }}</h2>
          <div class="course-program__intro">
            @foreach($syllabus['intro'][$locale] as $paragraph)
              <p>{{ $paragraph }}</p>
            @endforeach
          </div>
          <div class="course-program__modules">
            <p class="course-program__eyebrow">{{ $syllabus['modulesEyebrow'][$locale] }}</p>
            <ol>
              @foreach($syllabus['modules'][$locale] as $item)
                <li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><strong>{{ $item }}</strong></li>
              @endforeach
            </ol>
          </div>
        </div>
        <aside class="course-program__summary" aria-label="{{ $syllabus['volumeEyebrow'][$locale] }}">
          <p class="course-program__eyebrow">{{ $syllabus['volumeEyebrow'][$locale] }}</p>
          <dl>
            @foreach($syllabus['hours'][$locale] as [$label, $value])
              <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
            @endforeach
            <div class="course-program__total"><dt>{{ $syllabus['total'][$locale][0] }}</dt><dd>{{ $syllabus['total'][$locale][1] }}</dd></div>
          </dl>
        </aside>
      </div>
    </section>
  @endif


</main>
@endsection



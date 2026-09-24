@php
$fallbackCopy = [
 'ru'=>['eyebrow'=>'Оформить заявку','title'=>'Заявка','prefix'=>'Заявка на','intro'=>'Оставьте контакты, и мы свяжемся с вами по выбранному формату.','name'=>'Имя','email'=>'Email','phone'=>'Телефон','comment'=>'Комментарий','send'=>'Отправить заявку','close'=>'Закрыть заявку','selected'=>'Выбранный формат'],
 'lv'=>['eyebrow'=>'Nosūtīt pieprasījumu','title'=>'Pieprasījums','prefix'=>'Pieprasījums par','intro'=>'Atstājiet kontaktus, un mēs sazināsimies par izvēlēto formātu.','name'=>'Vārds','email'=>'Email','phone'=>'Telefons','comment'=>'Komentārs','send'=>'Nosūtīt pieprasījumu','close'=>'Aizvērt pieprasījumu','selected'=>'Izvēlētais formāts'],
 'en'=>['eyebrow'=>'Send request','title'=>'Request','prefix'=>'Request for','intro'=>'Leave your contacts and we will follow up about the selected format.','name'=>'Name','email'=>'Email','phone'=>'Phone','comment'=>'Comment','send'=>'Send request','close'=>'Close request','selected'=>'Selected format']
][$locale];
$copy = [
 'eyebrow' => soundiaLabel($labels ?? [], 'modal.eyebrow', $fallbackCopy['eyebrow']),
 'title' => soundiaLabel($labels ?? [], 'modal.title', $fallbackCopy['title']),
 'prefix' => soundiaLabel($labels ?? [], 'modal.prefix', $fallbackCopy['prefix']),
 'intro' => soundiaLabel($labels ?? [], 'modal.intro', $fallbackCopy['intro']),
 'name' => soundiaLabel($labels ?? [], 'modal.name', $fallbackCopy['name']),
 'email' => soundiaLabel($labels ?? [], 'modal.email', $fallbackCopy['email']),
 'phone' => soundiaLabel($labels ?? [], 'modal.phone', $fallbackCopy['phone']),
 'comment' => soundiaLabel($labels ?? [], 'modal.comment', $fallbackCopy['comment']),
 'send' => soundiaLabel($labels ?? [], 'modal.send', $fallbackCopy['send']),
 'close' => soundiaLabel($labels ?? [], 'modal.close', $fallbackCopy['close']),
 'selected' => soundiaLabel($labels ?? [], 'modal.selected', $fallbackCopy['selected']),
];
@endphp
<div class="order-modal order-modal--overlay" id="order-modal" role="dialog" aria-modal="true" aria-labelledby="order-modal-title" data-title-prefix="{{ $copy['prefix'] }}" data-default-title="{{ $copy['title'] }}" hidden>
  <div class="order-modal__dialog">
    <button class="order-modal__close" type="button" data-modal-close aria-label="{{ $copy['close'] }}">×</button>
    <div class="order-modal__panel"><div><p class="section-label">{{ $copy['eyebrow'] }}</p><h2 id="order-modal-title">{{ $copy['title'] }}</h2><p>{{ $copy['intro'] }}</p><p class="order-modal__selected" data-modal-selected hidden><span>{{ $copy['selected'] }}</span><strong></strong></p></div>
      <form class="order-modal__form" action="mailto:{{ $contacts['email'] }}" method="post" enctype="text/plain"><input type="hidden" name="request" data-modal-request>
        <label><span>{{ $copy['name'] }}</span><input name="name" required></label><label><span>{{ $copy['email'] }}</span><input name="email" type="email" required></label><label><span>{{ $copy['phone'] }}</span><input name="phone" type="tel"></label><label><span>{{ $copy['comment'] }}</span><textarea name="comment" rows="4"></textarea></label><button class="button button--filled button--md" type="submit">{{ $copy['send'] }}</button>
      </form>
    </div>
  </div>
</div>

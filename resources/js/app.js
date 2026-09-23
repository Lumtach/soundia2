import './bootstrap';
import '../css/soundia.css';

const header = document.querySelector('.site-header');
let menuScrollY = 0;
const updateHeader = () => {
  if (!header) return;
  header.classList.toggle('site-header--scrolled', window.scrollY > 12 || document.body.classList.contains('is-menu-open'));
};
window.addEventListener('scroll', updateHeader, { passive: true });
updateHeader();

const openMenu = () => {
  menuScrollY = window.scrollY || document.documentElement.scrollTop || 0;
  document.body.classList.add('is-menu-open');
  document.documentElement.classList.add('is-menu-open');
  document.body.style.position = 'fixed';
  document.body.style.top = `-${menuScrollY}px`;
  document.body.style.left = '0';
  document.body.style.right = '0';
  document.body.style.width = '100%';
  updateHeader();
};

const closeMenu = () => {
  const shouldRestore = document.body.classList.contains('is-menu-open');
  document.body.classList.remove('is-menu-open');
  document.documentElement.classList.remove('is-menu-open');
  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.left = '';
  document.body.style.right = '';
  document.body.style.width = '';
  if (shouldRestore) window.scrollTo(0, menuScrollY);
  updateHeader();
};

document.querySelectorAll('[data-menu-open]').forEach((button) => {
  button.addEventListener('click', openMenu);
});

document.querySelectorAll('[data-menu-close], .mobile-menu__overlay a').forEach((target) => {
  target.addEventListener('click', closeMenu);
});

document.querySelectorAll('.mobile-menu__overlay').forEach((overlay) => {
  overlay.addEventListener('click', (event) => {
    if (event.target === overlay) closeMenu();
  });
});


document.addEventListener('click', (event) => {
  document.querySelectorAll('.language-dropdown[open]').forEach((dropdown) => {
    if (!dropdown.contains(event.target)) dropdown.removeAttribute('open');
  });
});
document.addEventListener('click', (event) => {
  const trigger = event.target.closest('[data-modal-open]');
  const close = event.target.closest('[data-modal-close]');
  const overlay = event.target.classList?.contains('order-modal--overlay') ? event.target : null;
  if (trigger) {
    const id = trigger.getAttribute('data-modal-open');
    const modal = document.getElementById(id);
    const context = trigger.dataset.modalContext
      || trigger.closest('article')?.querySelector('h3')?.textContent?.trim()
      || trigger.closest('section')?.querySelector('h1')?.textContent?.trim()
      || trigger.closest('main')?.querySelector('h1')?.textContent?.trim()
      || trigger.textContent?.replace('↗', '').trim();

    if (modal) {
      const title = modal.querySelector('#order-modal-title');
      const selected = modal.querySelector('[data-modal-selected]');
      const selectedText = selected?.querySelector('strong');
      const requestInput = modal.querySelector('[data-modal-request]');
      const prefix = modal.dataset.titlePrefix || modal.dataset.defaultTitle || '';
      const defaultTitle = modal.dataset.defaultTitle || title?.textContent || '';

      if (context) {
        if (title) title.textContent = `${prefix} ${context}`.trim();
        if (selectedText) selectedText.textContent = context;
        if (selected) selected.removeAttribute('hidden');
        if (requestInput) requestInput.value = context;
      } else {
        if (title) title.textContent = defaultTitle;
        if (selected) selected.setAttribute('hidden', 'hidden');
        if (requestInput) requestInput.value = '';
      }

      modal.removeAttribute('hidden');
    }
    document.body.style.overflow = 'hidden';
  }
  if (close || overlay) {
    const modal = (close || overlay).closest('.order-modal');
    modal?.setAttribute('hidden', 'hidden');
    document.body.style.overflow = '';
  }
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    document.querySelectorAll('.order-modal:not([hidden])').forEach((modal) => modal.setAttribute('hidden', 'hidden'));
    closeMenu();
    document.body.style.overflow = '';
  }
});

document.querySelectorAll('.audio-player').forEach((player) => {
  const audio = player.querySelector('audio');
  const button = player.querySelector('button');
  if (!audio || !button) return;
  button.addEventListener('click', () => {
    if (audio.paused) {
      document.querySelectorAll('audio').forEach((item) => { if (item !== audio) item.pause(); });
      audio.play();
    } else {
      audio.pause();
    }
  });
  audio.addEventListener('play', () => {
    player.classList.add('is-playing');
    button.setAttribute('aria-label', button.dataset.pause || 'Pause');
    window.dispatchEvent(new CustomEvent('soundia-audio-state', { detail: { playing: true } }));
  });
  audio.addEventListener('pause', () => {
    player.classList.remove('is-playing');
    button.setAttribute('aria-label', button.dataset.play || 'Play');
    window.dispatchEvent(new CustomEvent('soundia-audio-state', { detail: { playing: false } }));
  });
});

const portfolioItems = document.querySelectorAll('[data-portfolio-project]');
const portfolioImage = document.querySelector('[data-portfolio-preview]');
if (portfolioItems.length && portfolioImage) {
  const activate = (item) => {
    portfolioItems.forEach((row) => row.classList.remove('is-active'));
    item.classList.add('is-active');
    portfolioImage.src = item.dataset.image;
    portfolioImage.alt = item.dataset.title || '';
  };
  portfolioItems.forEach((item) => {
    item.addEventListener('mouseenter', () => activate(item));
    item.addEventListener('focusin', () => activate(item));
  });
  const observer = new IntersectionObserver((entries) => {
    const current = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
    if (current) activate(current.target);
  }, { threshold: [0.35, 0.55, 0.75], rootMargin: '-18% 0px -18% 0px' });
  portfolioItems.forEach((item) => observer.observe(item));
}







const globalAudio = document.querySelector('[data-global-audio]');
const globalAudioToggle = document.querySelector('.global-audio-toggle');
const globalAudioStorageKey = 'soundia.globalAudio';

if (globalAudio && globalAudioToggle) {
  const readState = () => {
    try {
      return JSON.parse(localStorage.getItem(globalAudioStorageKey) || '{}');
    } catch (error) {
      return {};
    }
  };

  const writeState = (state = {}) => {
    const current = readState();
    localStorage.setItem(globalAudioStorageKey, JSON.stringify({ ...current, ...state, src: globalAudio.currentSrc || globalAudio.src }));
  };

  const updateGlobalAudioButton = () => {
    const playing = !globalAudio.paused;
    globalAudioToggle.setAttribute('aria-pressed', playing ? 'true' : 'false');
    globalAudioToggle.setAttribute('aria-label', playing ? 'Pause site audio' : 'Play site audio');
  };

  const restoreGlobalAudio = () => {
    const state = readState();
    if (state.src && state.src !== (globalAudio.currentSrc || globalAudio.src)) return;
    if (Number.isFinite(Number(state.time))) {
      const restoreTime = Number(state.time);
      globalAudio.addEventListener('loadedmetadata', () => {
        if (Number.isFinite(globalAudio.duration) && globalAudio.duration > 0) {
          globalAudio.currentTime = restoreTime % globalAudio.duration;
        } else {
          globalAudio.currentTime = restoreTime;
        }
      }, { once: true });
    }

    if (state.playing) {
      globalAudio.play().catch(() => updateGlobalAudioButton());
    }
  };

  globalAudioToggle.addEventListener('click', () => {
    if (globalAudio.paused) {
      document.querySelectorAll('audio').forEach((item) => { if (item !== globalAudio) item.pause(); });
      globalAudio.play().then(() => writeState({ playing: true })).catch(() => writeState({ playing: false }));
    } else {
      globalAudio.pause();
      writeState({ playing: false, time: globalAudio.currentTime || 0 });
    }
  });

  globalAudio.addEventListener('play', () => {
    writeState({ playing: true });
    updateGlobalAudioButton();
  });

  globalAudio.addEventListener('pause', () => {
    writeState({ playing: false, time: globalAudio.currentTime || 0 });
    updateGlobalAudioButton();
  });

  globalAudio.addEventListener('timeupdate', () => {
    writeState({ time: globalAudio.currentTime || 0, playing: !globalAudio.paused });
  });

  window.addEventListener('beforeunload', () => {
    writeState({ time: globalAudio.currentTime || 0, playing: !globalAudio.paused });
  });

  restoreGlobalAudio();
  updateGlobalAudioButton();
} else if (globalAudioToggle) {
  globalAudioToggle.disabled = true;
  globalAudioToggle.setAttribute('aria-disabled', 'true');
}

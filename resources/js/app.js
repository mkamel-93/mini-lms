import Plyr from 'plyr';
import 'plyr/dist/plyr.css';
import plyrSprite from '@/images/plyr.svg?url';
import collapse from '@alpinejs/collapse';


// 1. Register Alpine plugins (Livewire 3 handles the start)
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(collapse);
});

const initPlyr = () => {
    const players = Array.from(document.querySelectorAll('#video-player, .video-player'));

    players.forEach(player => {
        if (player.plyr) return;

        const instance = new Plyr(player, {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
            quality: { default: 720, options: [1080, 720, 480, 360] },
            iconUrl: plyrSprite
        });

        // This is the critical part to fix the screenshots
        instance.on('ready', (event) => {
            // event.detail.plyr.elements.container is the main div .plyr
            const wrapper = event.detail.plyr.elements.container;
            wrapper.classList.add('plyr--ready');
        });
    });
};

// 2. Initialize for both standard load and Livewire navigation
document.addEventListener('DOMContentLoaded', initPlyr);
document.addEventListener('livewire:navigated', initPlyr);

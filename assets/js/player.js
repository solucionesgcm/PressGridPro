/**
 * Native Text-to-Speech Player (Strict Spanish Best Voice Selection) - PressGrid Pro
 * Version: 19.6.0
 */

document.addEventListener('DOMContentLoaded', () => {
    const playBtn = document.querySelector('.audio-play-btn');
    const audioInfo = document.querySelector('.audio-info');
    const progressBar = document.querySelector('.audio-progress');
    const progressFill = document.querySelector('.audio-progress-fill');

    if (!playBtn || !('speechSynthesis' in window)) {
        if (playBtn) playBtn.style.display = 'none';
        return;
    }

    let isPlaying = false;
    let synth = window.speechSynthesis;
    let utterance = null;
    let selectedVoice = null;

    // Búsqueda estricta de voces exclusivas en español
    function loadBestVoice() {
        const voices = synth.getVoices();
        if (!voices.length) return;

        // Filtrar ÚNICAMENTE voces cuyo código empiece estrictamente por "es"
        const spanishVoices = voices.filter(voice => {
            const lang = voice.lang.toLowerCase().replace('_', '-');
            return lang.startsWith('es');
        });

        if (!spanishVoices.length) return;

        // Prioridad 1: Voces Neurales / Premium en Español México o España (Google, Microsoft, Apple)
        selectedVoice = spanishVoices.find(v => {
            const name = v.name.toLowerCase();
            const lang = v.lang.toLowerCase();
            return (lang.includes('mx') || lang.includes('es') || lang.includes('us')) && 
                   (name.includes('google') || name.includes('natural') || name.includes('premium') || name.includes('enhanced') || name.includes('online'));
        }) 
        // Prioridad 2: Cualquier voz oficial de México (es-MX)
        || spanishVoices.find(v => v.lang.toLowerCase().includes('mx'))
        // Prioridad 3: Cualquier voz oficial en Español (es-ES / es-US)
        || spanishVoices.find(v => v.lang.toLowerCase().includes('es') || v.lang.toLowerCase().includes('us'))
        // Prioridad 4: Primera voz de la lista en español
        || spanishVoices[0];

        // Forzar el atributo de idioma a español neutro/mexicano
        if (selectedVoice) {
            console.log('PressGrid Player — Voz seleccionada:', selectedVoice.name, selectedVoice.lang);
        }
    }

    // Inicialización y re-escucha para carga asíncrona de voces en navegadores basados en Chromium
    loadBestVoice();
    if (speechSynthesis.onvoiceschanged !== undefined) {
        speechSynthesis.onvoiceschanged = loadBestVoice;
    }

    function getArticleText() {
        const headline = document.querySelector('.pgp-hero-headline')?.innerText || '';
        const subtitle = document.querySelector('.pgp-hero-subtitle')?.innerText || '';
        const content = document.querySelector('.post-content')?.innerText || '';
        
        return `${headline}. ${subtitle}. ${content}`;
    }

    function updateProgress(percent) {
        const progress = Math.max(0, Math.min(100, percent));
        if (progressFill) progressFill.style.width = `${progress}%`;
        if (progressBar) progressBar.setAttribute('aria-valuenow', String(progress));
    }

    function toggleSpeech() {
        if (isPlaying) {
            synth.pause();
            isPlaying = false;
            updateUI(false);
        } else {
            if (synth.paused) {
                synth.resume();
                isPlaying = true;
                updateUI(true);
            } else {
                synth.cancel(); // Limpieza previa
                updateProgress(0);

                const textToRead = getArticleText();
                utterance = new SpeechSynthesisUtterance(textToRead);

                // Configurar idioma explícito en la emisión
                utterance.lang = selectedVoice ? selectedVoice.lang : 'es-MX';

                if (selectedVoice) {
                    utterance.voice = selectedVoice;
                }
                
                utterance.rate = 1.0;  // Velocidad normal
                utterance.pitch = 1.0; // Tono estándar

                utterance.onboundary = event => {
                    if (textToRead.length > 0) {
                        updateProgress((event.charIndex / textToRead.length) * 100);
                    }
                };

                utterance.onend = () => {
                    isPlaying = false;
                    updateProgress(100);
                    updateUI(false);
                };

                utterance.onerror = () => {
                    isPlaying = false;
                    updateProgress(0);
                    updateUI(false);
                };

                synth.speak(utterance);
                isPlaying = true;
                updateUI(true);
            }
        }
    }

    function updateUI(playing) {
        if (playing) {
            playBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>';
            audioInfo.textContent = 'Pausar lectura de audio';
        } else {
            playBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>';
            audioInfo.textContent = 'Escuchar versión en audio';
        }
    }

    playBtn.addEventListener('click', toggleSpeech);
});
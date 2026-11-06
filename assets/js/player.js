/**
 * Native Text-to-Speech Player (Best Voice Selection) - PressGrid Pro
 * Version: 19.4.0
 */

document.addEventListener('DOMContentLoaded', () => {
    const playBtn = document.querySelector('.audio-play-btn');
    const audioInfo = document.querySelector('.audio-info');

    if (!playBtn || !('speechSynthesis' in window)) {
        if (playBtn) playBtn.style.display = 'none';
        return;
    }

    let isPlaying = false;
    let synth = window.speechSynthesis;
    let utterance = null;
    let selectedVoice = null;

    // Buscar y seleccionar la mejor voz en español disponible en el navegador
    function loadBestVoice() {
        const voices = synth.getVoices();
        
        // Prioridad de voces de alta calidad (Google, Microsoft Premium, Apple Premium)
        selectedVoice = voices.find(voice => 
            (voice.lang.includes('es') || voice.lang.includes('ES')) && 
            (voice.name.includes('Google') || voice.name.includes('Premium') || voice.name.includes('Natural') || voice.name.includes('Enhanced'))
        ) || voices.find(voice => 
            voice.lang.startsWith('es-MX') || voice.lang.startsWith('es-ES') || voice.lang.startsWith('es-US')
        ) || voices.find(voice => 
            voice.lang.includes('es')
        );
    }

    // Cargar voces (algunos navegadores las cargan de forma asíncrona)
    loadBestVoice();
    if (speechSynthesis.onvoiceschanged !== undefined) {
        speechSynthesis.onvoiceschanged = loadBestVoice;
    }

    // Extraer texto ordenado de la nota
    function getArticleText() {
        const headline = document.querySelector('.pgp-hero-headline')?.innerText || '';
        const subtitle = document.querySelector('.pgp-hero-subtitle')?.innerText || '';
        const content = document.querySelector('.post-content')?.innerText || '';
        
        return `${headline}. ${subtitle}. ${content}`;
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
                synth.cancel(); // Limpiar lecturas anteriores

                const textToRead = getArticleText();
                utterance = new SpeechSynthesisUtterance(textToRead);

                if (selectedVoice) {
                    utterance.voice = selectedVoice;
                }
                
                utterance.rate = 1.0;  // Velocidad natural
                utterance.pitch = 1.0; // Tono natural

                utterance.onend = () => {
                    isPlaying = false;
                    updateUI(false);
                };

                utterance.onerror = () => {
                    isPlaying = false;
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
            audioInfo.textContent = 'Pausar reproducción en audio';
        } else {
            playBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>';
            audioInfo.textContent = 'Escuchar versión en audio';
        }
    }

    playBtn.addEventListener('click', toggleSpeech);
});
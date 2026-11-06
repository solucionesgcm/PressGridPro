document.addEventListener('DOMContentLoaded', () => {
    const player = document.querySelector('.pgp-audio-player-bar');
    if (!player) return;

    const playButton = player.querySelector('.audio-play-btn');
    const restartButton = player.querySelector('.audio-restart-btn');
    const playIcon = player.querySelector('.player-play-icon');
    const pauseIcon = player.querySelector('.player-pause-icon');
    const info = player.querySelector('.audio-info');
    const durationEstimateLabel = player.querySelector('.audio-duration-estimate');
    const status = player.querySelector('.audio-status');
    const speedControl = player.querySelector('.audio-speed');
    const progressGroup = player.querySelector('.audio-progress-group');
    const progress = player.querySelector('.audio-progress');
    const currentTime = player.querySelector('.audio-current-time');
    const duration = player.querySelector('.audio-duration');
    const audioSource = player.dataset.audioSrc;
    const audio = audioSource ? new Audio(audioSource) : null;
    const speech = window.speechSynthesis;

    let isPlaying = false;
    let isPaused = false;
    let utterance = null;
    let speechChunks = [];
    let chunkIndex = 0;
    let speechRate = Number(speedControl.value);
    let selectedVoice = null;
    let speechText = '';
    let estimatedDuration = 0;

    function setStatus(message) {
        status.textContent = message;
    }

    function updatePlayButton(playing) {
        isPlaying = playing;
        playIcon.hidden = playing;
        pauseIcon.hidden = !playing;
        playButton.setAttribute(
            'aria-label',
            playing ? 'Pausar lectura' : 'Escuchar artículo'
        );
        info.textContent = player.dataset.idleLabel;
    }

    function formatTime(seconds) {
        const totalSeconds = Math.floor(seconds);
        const minutes = Math.floor(totalSeconds / 60);
        const remainingSeconds = totalSeconds % 60;

        return `${minutes}:${String(remainingSeconds).padStart(2, '0')}`;
    }

    function updateProgress() {
        if (!audio || !Number.isFinite(audio.duration) || audio.duration <= 0) return;

        progress.value = String((audio.currentTime / audio.duration) * 100);
        currentTime.textContent = formatTime(audio.currentTime);
        duration.textContent = formatTime(audio.duration);
        durationEstimateLabel.textContent = `(${formatMinutes(audio.duration)})`;
    }

    function updateEstimatedProgress(fraction) {
        if (!estimatedDuration) return;

        const boundedFraction = Math.max(0, Math.min(1, fraction));
        progress.value = String(boundedFraction * 100);
        currentTime.textContent = formatTime(estimatedDuration * boundedFraction);
        duration.textContent = `~${formatTime(estimatedDuration)}`;
    }

    function formatMinutes(seconds) {
        const minutes = Math.max(1, Math.ceil(seconds / 60));
        return `${minutes} min`;
    }

    function loadSpanishVoice() {
        if (!speech) return;

        const spanishVoices = speech.getVoices().filter((voice) => {
            const language = voice.lang.toLowerCase().replace('_', '-');
            return 'es' === language || language.startsWith('es-');
        });

        selectedVoice =
            spanishVoices.find((voice) =>
                voice.lang.toLowerCase().replace('_', '-').startsWith('es-mx')
            ) || spanishVoices[0] || null;
    }

    function getArticleText() {
        const headline = document.querySelector('.pgp-hero-headline')?.innerText || '';
        const subtitle = document.querySelector('.pgp-hero-subtitle')?.innerText || '';
        const content = document.querySelector('.post-content')?.innerText || '';

        return [headline, subtitle, content].filter(Boolean).join('. ');
    }

    function estimateSpeechDuration() {
        const wordCount = speechText.trim().split(/\s+/).filter(Boolean).length;
        estimatedDuration = wordCount
            ? Math.ceil((wordCount / (165 * speechRate)) * 60)
            : 0;
        duration.textContent = estimatedDuration
            ? `~${formatTime(estimatedDuration)}`
            : '0:00';
        durationEstimateLabel.textContent = estimatedDuration
            ? `(~${formatMinutes(estimatedDuration)})`
            : '';
    }

    function makeSpeechChunks(text) {
        const sentences = text.match(/[^.!?]+[.!?]+|[^.!?]+$/g) || [text];
        const chunks = [];
        let chunk = '';

        sentences.forEach((sentence) => {
            const part = sentence.trim();
            if (!part) return;

            if (chunk && `${chunk} ${part}`.length > 180) {
                chunks.push(chunk);
                chunk = '';
            }

            if (part.length > 180) {
                const words = part.split(/\s+/);
                words.forEach((word) => {
                    if (chunk && `${chunk} ${word}`.length > 180) {
                        chunks.push(chunk);
                        chunk = '';
                    }
                    chunk = chunk ? `${chunk} ${word}` : word;
                });
            } else {
                chunk = chunk ? `${chunk} ${part}` : part;
            }
        });

        if (chunk) chunks.push(chunk);
        return chunks;
    }

    function speakCurrentChunk() {
        if (chunkIndex >= speechChunks.length) {
            utterance = null;
            isPaused = false;
            updatePlayButton(false);
            setStatus('Lectura finalizada.');
            return;
        }

        const nextUtterance = new SpeechSynthesisUtterance(speechChunks[chunkIndex]);
        utterance = nextUtterance;
        nextUtterance.rate = speechRate;
        nextUtterance.pitch = 1;
        nextUtterance.lang = selectedVoice?.lang || 'es-MX';

        if (selectedVoice) {
            nextUtterance.voice = selectedVoice;
        }

        const previousChunkLength = speechChunks
            .slice(0, chunkIndex)
            .reduce((length, chunk) => length + chunk.length, 0);
        const totalTextLength = speechChunks.reduce(
            (length, chunk) => length + chunk.length,
            0
        );

        nextUtterance.onboundary = (event) => {
            if (
                utterance === nextUtterance
                && totalTextLength
                && Number.isFinite(event.charIndex)
            ) {
                updateEstimatedProgress(
                    (previousChunkLength + event.charIndex) / totalTextLength
                );
            }
        };

        nextUtterance.onend = () => {
            if (utterance !== nextUtterance) return;
            chunkIndex += 1;
            updateEstimatedProgress(
                chunkIndex >= speechChunks.length
                    ? 1
                    : speechChunks
                        .slice(0, chunkIndex)
                        .reduce((length, chunk) => length + chunk.length, 0)
                        / totalTextLength
            );
            speakCurrentChunk();
        };

        nextUtterance.onerror = (event) => {
            if (utterance !== nextUtterance || 'canceled' === event.error) return;
            utterance = null;
            isPaused = false;
            updatePlayButton(false);
            setStatus('No se pudo iniciar la lectura por voz.');
        };

        speech.speak(nextUtterance);
    }

    function startSpeech() {
        if (!speech) {
            updatePlayButton(false);
            playButton.disabled = true;
            restartButton.disabled = true;
            setStatus('Este navegador no admite lectura por voz.');
            return;
        }

        if (!speechChunks.length) {
            speechText = getArticleText();
            speechChunks = makeSpeechChunks(speechText);
            estimateSpeechDuration();
        }

        if (!speechChunks.length) {
            setStatus('No hay texto disponible para leer.');
            return;
        }

        isPaused = false;
        updateEstimatedProgress(
            speechChunks
                .slice(0, chunkIndex)
                .reduce((length, chunk) => length + chunk.length, 0)
                / speechChunks.reduce((length, chunk) => length + chunk.length, 0)
        );
        updatePlayButton(true);
        setStatus('Lectura automática con voz sintética.');
        speakCurrentChunk();
    }

    function playAudio() {
        audio.play().catch(() => {
            updatePlayButton(false);
            setStatus('No se pudo reproducir el archivo de audio.');
        });
    }

    if (audio) {
        progressGroup.hidden = false;
        audio.preload = 'metadata';
        audio.addEventListener('loadedmetadata', updateProgress);
        audio.addEventListener('timeupdate', updateProgress);
        audio.addEventListener('play', () => updatePlayButton(true));
        audio.addEventListener('pause', () => updatePlayButton(false));
        audio.addEventListener('ended', () => {
            updatePlayButton(false);
            setStatus('Audio finalizado.');
        });
        audio.addEventListener('error', () => {
            setStatus('No se pudo cargar el archivo de audio.');
        });
    } else {
        loadSpanishVoice();
        speech?.addEventListener('voiceschanged', loadSpanishVoice);
        progress.setAttribute('aria-label', 'Posición estimada de lectura');
        speechText = getArticleText();
        speechChunks = makeSpeechChunks(speechText);
        estimateSpeechDuration();
        progress.addEventListener('change', () => {
            if (!speechChunks.length) {
                speechText = getArticleText();
                speechChunks = makeSpeechChunks(speechText);
                estimateSpeechDuration();
            }

            if (!speechChunks.length) return;

            const target = Number(progress.value) / 100;
            const totalLength = speechChunks.reduce(
                (length, chunk) => length + chunk.length,
                0
            );
            let targetLength = totalLength * target;
            chunkIndex = 0;

            while (
                chunkIndex < speechChunks.length - 1
                && targetLength > speechChunks[chunkIndex].length
            ) {
                targetLength -= speechChunks[chunkIndex].length;
                chunkIndex += 1;
            }

            updateEstimatedProgress(target);
            if (isPlaying || isPaused) {
                speech.cancel();
                utterance = null;
                isPaused = false;
                startSpeech();
            }
        });
    }

    playButton.addEventListener('click', () => {
        if (audio) {
            if (audio.paused) {
                playAudio();
            } else {
                audio.pause();
            }
            return;
        }

        if (!speech) {
            startSpeech();
            return;
        }

        if (isPlaying) {
            speech.pause();
            isPaused = true;
            updatePlayButton(false);
            setStatus('Lectura en pausa.');
        } else if (isPaused) {
            if (utterance) {
                speech.resume();
                isPaused = false;
                updatePlayButton(true);
                setStatus('Lectura automática con voz sintética.');
            } else {
                startSpeech();
            }
        } else {
            if (chunkIndex >= speechChunks.length) chunkIndex = 0;
            startSpeech();
        }
    });

    restartButton.addEventListener('click', () => {
        if (audio) {
            audio.currentTime = 0;
            setStatus('');
            playAudio();
            return;
        }

        if (!speech) return;

        utterance = null;
        speech.cancel();
        chunkIndex = 0;
        isPaused = false;
        updateEstimatedProgress(0);
        startSpeech();
    });

    speedControl.addEventListener('change', () => {
        const rate = Number(speedControl.value);

        if (audio) {
            audio.playbackRate = rate;
            setStatus(`Velocidad: ${rate}×.`);
            return;
        }

        speechRate = rate;
        if (speechChunks.length) estimateSpeechDuration();
        if (isPlaying) {
            utterance = null;
            speech.cancel();
            updateEstimatedProgress(
                speechChunks
                    .slice(0, chunkIndex)
                    .reduce((length, chunk) => length + chunk.length, 0)
                    / speechChunks.reduce((length, chunk) => length + chunk.length, 0)
            );
            speakCurrentChunk();
            updatePlayButton(true);
        } else if (isPaused && utterance) {
            utterance = null;
            speech.cancel();
        }

        setStatus(`Velocidad de lectura: ${rate}×.`);
    });

    if (audio) {
        progress.addEventListener('input', () => {
            if (Number.isFinite(audio.duration)) {
                audio.currentTime = (Number(progress.value) / 100) * audio.duration;
            }
        });
    }
});

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $photo_caption = get_post_meta(get_the_ID(), '_gcm_photo_caption', true);
    $photo_credit  = get_post_meta(get_the_ID(), '_gcm_photo_credit', true);
    ?>

    <!-- 1. LLAMAMOS AL HERO -->
    <?php get_template_part('template-parts/single/hero'); ?>

    <!-- 2. CUERPO (Imagen y Texto) -->
    <section class="nbc-body-section">
        <div class="nbc-container-wide">
            
            <!-- Imagen flotante -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="nbc-image-wrapper">
                    <div class="nbc-image-container">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                        <div class="nbc-image-caption">
                            <?php if (!empty($photo_caption)) : ?><div class="nbc-caption-text"><?php echo esc_html($photo_caption); ?></div><?php endif; ?>
                            <?php if (!empty($photo_credit)) : ?><div class="nbc-photo-credit"><?php echo esc_html($photo_credit); ?></div><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Layout de 2 columnas: Texto y Sidebar -->
            <div class="nbc-body-grid">
                
                <main class="nbc-body-main">
                    <div class="nbc-action-bar">
                        <a href="#" class="nbc-action-btn">SHARE</a>
                        <div class="nbc-action-divider"></div>
                        <a href="#" class="nbc-action-btn">ADD GCM NOTICIAS TO GOOGLE</a>
                    </div>

                    <div class="nbc-meta-info">
                        <span class="nbc-pub-date"><?php echo get_the_date('M. j, Y, g:i A T'); ?></span>
                        <span class="nbc-author-name">By <?php the_author(); ?></span>
                    </div>

                    <div class="nbc-post-content" id="article-content-for-tts">
                        <?php the_content(); ?>
                    </div>

                    <div class="gcm-post-nav-strip">
                        <div class="nav-prev"><?php previous_post_link('%link', '← Nota Anterior: %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%title: %link →'); ?></div>
                    </div>
                </main>

                <aside class="nbc-body-sidebar">
                    <?php get_template_part('template-parts/home/sidebar'); ?>
                </aside>

            </div>
        </div>
    </section>

<?php endwhile; ?>

<!-- SCRIPT: SÍNTESIS DE VOZ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('play-audio-btn');
    const iconPlay = document.getElementById('icon-play');
    const iconPause = document.getElementById('icon-pause');
    const audioText = document.getElementById('audio-text');
    const progressFill = document.getElementById('audio-progress-fill');
    const timeCurrent = document.getElementById('audio-current-time');
    const timeDuration = document.getElementById('audio-duration');
    
    if (!btn) return;

    let utterance = null;
    let timerInterval = null;
    let startTime = 0;
    let elapsed = 0;
    let isSpeaking = false;
    let voices = [];

    function loadVoices() {
        voices = window.speechSynthesis.getVoices();
        if (voices.length === 0) setTimeout(loadVoices, 250);
    }
    window.speechSynthesis.onvoiceschanged = loadVoices;
    loadVoices();

    function getArticleText() {
        const title = document.querySelector('.nbc-title')?.innerText || '';
        const subtitle = document.querySelector('.nbc-subtitle')?.innerText || '';
        const contentDiv = document.getElementById('article-content-for-tts');
        if (!contentDiv) return title + ' ' + subtitle;
        
        const clone = contentDiv.cloneNode(true);
        clone.querySelectorAll('script, style, pre, code').forEach(el => el.remove());
        const content = clone.innerText || '';
        return `${title}. ${subtitle}. ${content}`.replace(/\s+/g, ' ').trim();
    }

    function formatTime(seconds) {
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }

    function startTimer() {
        startTime = Date.now() - (elapsed * 1000);
        timerInterval = setInterval(() => {
            elapsed = (Date.now() - startTime) / 1000;
            timeCurrent.textContent = formatTime(elapsed);
            const text = getArticleText();
            const wordCount = text.split(/\s+/).length;
            const estimatedDuration = (wordCount / 150) * 60;
            timeDuration.textContent = formatTime(estimatedDuration);
            if (estimatedDuration > 0) {
                const percent = Math.min((elapsed / estimatedDuration) * 100, 100);
                progressFill.style.width = percent + '%';
            }
        }, 1000);
    }

    function stopTimer() { clearInterval(timerInterval); }

    function resetPlayer() {
        stopTimer();
        elapsed = 0;
        timeCurrent.textContent = '00:00';
        progressFill.style.width = '0%';
        isSpeaking = false;
        iconPlay.style.display = 'block';
        iconPause.style.display = 'none';
        audioText.textContent = 'Listen to this article with a free profile';
        utterance = null;
    }

    function getBestVoice() {
        if (voices.length === 0) return null;
        let best = voices.find(v => v.lang.includes('es-MX') && v.name.includes('Google'));
        if (best) return best;
        best = voices.find(v => v.lang.includes('es-US') && v.name.includes('Google'));
        if (best) return best;
        best = voices.find(v => v.lang.includes('es-') && (v.name.includes('Natural') || v.name.includes('Premium')));
        if (best) return best;
        best = voices.find(v => v.name.includes('Paulina') || v.name.includes('Sabina') || v.name.includes('Mónica'));
        if (best) return best;
        best = voices.find(v => v.lang.includes('es-419') || v.lang.includes('es-MX'));
        if (best) return best;
        return voices.find(v => v.lang.startsWith('es-'));
    }

    if ('speechSynthesis' in window) {
        btn.addEventListener('click', function() {
            if (window.speechSynthesis.paused && isSpeaking) {
                window.speechSynthesis.resume();
                startTimer();
                iconPlay.style.display = 'none';
                iconPause.style.display = 'block';
                audioText.textContent = 'Pause reading';
                return;
            }
            if (window.speechSynthesis.speaking && !window.speechSynthesis.paused) {
                window.speechSynthesis.pause();
                stopTimer();
                iconPlay.style.display = 'block';
                iconPause.style.display = 'none';
                audioText.textContent = 'Resume reading';
                return;
            }
            if (!utterance || !window.speechSynthesis.speaking) {
                const text = getArticleText();
                if (!text) return;
                utterance = new SpeechSynthesisUtterance(text);
                const bestVoice = getBestVoice();
                if (bestVoice) utterance.voice = bestVoice;
                utterance.rate = 1;
                utterance.pitch = 1;
                utterance.onstart = function() {
                    isSpeaking = true;
                    iconPlay.style.display = 'none';
                    iconPause.style.display = 'block';
                    audioText.textContent = 'Pause reading';
                    startTimer();
                };
                utterance.onend = function() { resetPlayer(); };
                utterance.onerror = function(e) {
                    audioText.textContent = 'Error al leer el artículo.';
                    resetPlayer();
                };
                window.speechSynthesis.speak(utterance);
            }
        });
    }
});
</script>

<?php get_footer(); ?>
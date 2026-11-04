<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php 
    $photo_caption = get_post_meta(get_the_ID(), '_gcm_photo_caption', true);
    $photo_credit  = get_post_meta(get_the_ID(), '_gcm_photo_credit', true);
    
    $cats = get_the_category();
    $category_name = !empty($cats) ? $cats[0]->name : 'EXCLUSIVO';
    $kicker = get_post_meta(get_the_ID(), '_gcm_kicker', true);
    
    $clean_cat = strtolower(remove_accents(trim($category_name)));
    $clean_kicker = strtolower(remove_accents(trim($kicker)));
    
    if ($clean_kicker === $clean_cat || empty($kicker)) {
        $kicker = '';
    }
    ?>

    <!-- 1. HERO OSCURO -->
    <section class="nbc-hero-dark">
        <div class="nbc-container">
            
            <!-- Columna 1: Categoría -->
            <div class="nbc-cat-col">
                <span class="nbc-cat-label"><?php echo esc_html($category_name); ?></span>
                <?php if (!empty($kicker)) : ?>
                    <span class="nbc-kicker-label"><?php echo esc_html($kicker); ?></span>
                <?php endif; ?>
            </div>

            <!-- Columna 2: Título, Subtítulo y Audio -->
            <div class="nbc-main-col">
                <h1 class="nbc-title"><?php the_title(); ?></h1>

                <?php 
                $subtitle = get_post_meta(get_the_ID(), '_gcm_subtitle', true);
                if (!empty($subtitle)) : ?>
                    <p class="nbc-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <!-- Reproductor de Audio -->
                <div class="nbc-audio-player-container">
                    <button id="play-audio-btn" class="nbc-audio-play-btn" aria-label="Escuchar artículo">
                        <svg id="icon-play" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        <svg id="icon-pause" style="display:none;" width="20" height="20" viewBox="0 0 24 24" fill="#0f172a"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                    </button>
                    
                    <div class="nbc-audio-content">
                        <div class="nbc-audio-text-row">
                            <span id="audio-text">Listen to this article with a free profile</span>
                        </div>
                        <div class="nbc-audio-progress-row">
                            <span id="audio-current-time">00:00</span>
                            <div class="nbc-audio-progress-bar" id="audio-progress-container">
                                <div class="nbc-audio-progress-fill" id="audio-progress-fill"></div>
                            </div>
                            <span id="audio-duration">04:28</span>
                            <span class="nbc-audio-speed">1x</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" style="margin-left: 5px;"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. IMAGEN FLOTANTE -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="nbc-image-wrapper">
            <div class="nbc-container">
                <div></div> <!-- Espacio vacío para la columna 1 -->
                <div class="nbc-main-col">
                    <div class="nbc-image-container">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <?php if (!empty($photo_caption) || !empty($photo_credit)) : ?>
                        <div class="nbc-image-caption">
                            <?php if (!empty($photo_caption)) : ?>
                                <div class="nbc-caption-text"><?php echo esc_html($photo_caption); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($photo_credit)) : ?>
                                <div class="nbc-photo-credit"><?php echo esc_html($photo_credit); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3. CUERPO DEL ARTÍCULO Y SIDEBAR -->
    <section class="nbc-body-section">
        <div class="nbc-container">
            
            <div></div> <!-- Espacio vacío para la columna 1 -->

            <!-- Columna 2: Contenido -->
            <main class="nbc-main-col">
                <div class="nbc-action-bar">
                    <a href="#" class="nbc-action-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>
                        SHARE
                    </a>
                    <div class="nbc-action-divider"></div>
                    <a href="#" class="nbc-action-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        ADD GCM NOTICIAS TO GOOGLE
                    </a>
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

            <!-- Columna 3: Sidebar -->
            <aside class="nbc-sidebar-col">
                <?php get_template_part('template-parts/home/sidebar'); ?>
            </aside>

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
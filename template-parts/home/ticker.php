<div class="gcm-ticker-bar">
    <div class="container gcm-ticker-container">
        <div class="ticker-badge">MERCADOS & EN VIVO</div>
        <div class="ticker-content">
            <span class="ticker-item"><strong>S&P 500:</strong> +0.45%</span>
            <span class="ticker-item"><strong>NASDAQ:</strong> +0.82%</span>
            <span class="ticker-item"><strong>BRENT:</strong> $74.20 (-1.1%)</span>
            
            <?php 
            $opts = get_option('pressgrid_options');
            $ticker_text = !empty($opts['ticker_text']) ? $opts['ticker_text'] : 'Mercados reaccionan ante nuevos anuncios de la FED';
            ?>
            <span class="ticker-item highlight"><strong>ÚLTIMA HORA:</strong> <?php echo esc_html($ticker_text); ?></span>
        </div>
    </div>
</div>
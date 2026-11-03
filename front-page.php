/* --- ESTILOS DEL CUERPO INFERIOR DE PORTADA --- */
.pressgrid-sections-block {
    margin-top: 3.5rem;
    padding-top: 2rem;
    border-top: 2px solid var(--text-primary);
}

.section-block-title {
    font-size: 1.1rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: -0.2px;
    margin-bottom: 1.75rem;
    color: var(--text-primary);
}

.pressgrid-3col-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

@media (max-width: 900px) {
    .pressgrid-3col-grid {
        grid-template-columns: 1fr;
    }
}

.pressgrid-card-item {
    display: flex;
    flex-direction: column;
}

.card-thumb-link {
    display: block;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    border-radius: 3px;
    background: #e2e8f0;
    margin-bottom: 0.85rem;
}

.card-thumb-link img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-meta-tag {
    font-family: var(--font-mono);
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--brand-red);
    text-transform: uppercase;
    margin-bottom: 0.35rem;
}

.card-title {
    font-size: 1.1rem;
    line-height: 1.25;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
}

.card-title a {
    color: var(--text-primary);
    text-decoration: none;
}

.card-excerpt {
    font-family: var(--font-serif-excerpt);
    font-size: 0.925rem;
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0;
}

.pressgrid-bottom-feed-section {
    margin-top: 4rem;
    padding-top: 2.5rem;
    border-top: 1px solid var(--border-color);
}

.pressgrid-main-with-sidebar {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 3rem;
}

@media (max-width: 900px) {
    .pressgrid-main-with-sidebar {
        grid-template-columns: 1fr;
    }
}

.feed-header-title {
    font-size: 1rem;
    font-weight: 900;
    text-transform: uppercase;
    border-bottom: 2px solid var(--text-primary);
    padding-bottom: 0.5rem;
    margin-top: 0;
    margin-bottom: 1.5rem;
}

.pressgrid-list-item {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 1.25rem;
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.list-thumb {
    display: block;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    border-radius: 3px;
    background: #e2e8f0;
}

.list-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.list-date {
    font-family: var(--font-mono);
    font-size: 0.7rem;
    color: var(--text-muted);
    text-transform: uppercase;
}

.list-title {
    font-size: 1.05rem;
    font-weight: 800;
    line-height: 1.3;
    margin: 0.25rem 0 0.4rem 0;
}

.list-title a {
    color: var(--text-primary);
    text-decoration: none;
}

.list-excerpt {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.45;
}
